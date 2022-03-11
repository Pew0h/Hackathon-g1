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

class TestController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route(path: '/test', name: 'test')]
    public function showTest() : Response
    {
        return $this->render('test.html.twig', ['var'=> 'test']);
    }

}
