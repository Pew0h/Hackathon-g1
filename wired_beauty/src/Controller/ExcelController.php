<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Campain;
use App\Entity\Choice;
use App\Entity\Qcm;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExcelController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function parseExcelToJson($file_path, $qcm_name)
    {
        $file = new File("Excels/" . $file_path);
        $reader = new Xlsx();
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $array = [];
        $array_response = [];
        $letter = 'A';
        $questionNumber = 1;

        for ($i = 2; $i < $sheet->getHighestRow() + 2; $i++) {
            try {
                $activeCell = $sheet->getCell($letter . $i)->getValue();
            } catch (\Exception $e) {
                break; // We have reached the end of the excel
            }
            if ($activeCell) {
                if ((ord(strtoupper($letter)) - ord('A') + 1) % 2) { // Check if the letter of the column is odd
                    $array[$questionNumber]['question'] = $activeCell;
                } else { // We add the answers in the table
                    $array_response[] = $activeCell;
                }
            } else {

                $i = 1; // Start again at the beginning of the first row of the column
                ++$letter; // We go to the next column (Next letter)
                if ((ord(strtoupper($letter)) - ord('A') + 1) % 2) {
                    if ($array_response) {
                        $array[$questionNumber]['response'] = $array_response;
                        $array_response = [];
                    }
                    $questionNumber++;
                }
            }
        }
        $qcm = $this->addQCMToDatabase($array, $qcm_name);

        $filesystem = new Filesystem();
        $filesystem->remove($file);
        return $qcm;
    }

    public function addQCMToDatabase(array $array, $qcm_name)
    {
        // Get first campain for example
        $campain = $this->em->getRepository(Campain::class)->find(1);

        // Create QCM
        $qcm = new Qcm();
        $qcm->setName($qcm_name);
        $qcm->setCampain($campain);
        $this->em->persist($qcm);

        // Get the total number of questions
        $questions_numbers = 0;
        foreach ($array as $key => $value) {
            if (array_key_exists('question', $value)) {
                $questions_numbers++;
            }
        }

        //Creation of the QCM with the associated questions and answers
        for ($i = 1; $i < $questions_numbers; $i++) {
            // Question creation
            $questions = new Question();
            $questions->setQcm($qcm);
            $questions->setName($array[$i]['question']);
            $this->em->persist($questions);
            $this->em->flush();
            foreach ($array[$i]['response'] as $value) {
                $choice = new Choice();
                $choice->setQuestion($questions);
                $choice->setValue($value);
                $this->em->persist($choice);
            }
            $this->em->flush();
        }

        return $qcm;
    }
}
