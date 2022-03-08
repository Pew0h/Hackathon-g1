<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExcelController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function viewTest(): Response
    {
        return $this->render('test.html.twig');
    }

    #[Route('/upload-excel-file', name: 'upload-excel-file')]
    public function uploadExcelFile(Request $request): Response
    {
        $file = $request->files->get('excelFile');
        if (empty($file))
        {
            return $this->render('test.html.twig', ['error' => 'Empty file']);
        }

        $this->parseExcelToJson($file);
    }

    public function parseExcelToJson($file): Response
    {

        $reader = new Xlsx();
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $json = array();
        $letter = 'A';
        $questionNumber = 1;

        for($i = 2; $i < $sheet->getHighestRow() + 2; $i++){
            try{
                $activeCell = $sheet->getCell($letter. $i)->getValue();
            }catch(\Exception $e){
                break; // Nous avons atteint la fin de l'excel
            }
            if($activeCell){
                if((ord(strtoupper($letter)) - ord('A') + 1) % 2){
                    $json['question_'. $questionNumber] = $activeCell;
                }
                else{
                    $json['response_'. $questionNumber . '_' . $i-1] = $activeCell;
                }

            }else{
                $i = 1; // On recommence en début de la première ligne de la colonne
                ++$letter; // On passe à la prochaine colonne
                if((ord(strtoupper($letter)) - ord('A') + 1) % 2){
                    $questionNumber++;
                }
                // On incrémente le numéro de la question
            }
        }
        dd($json);
    }

}