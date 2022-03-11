<?php

namespace App\Controller\Admin;

use App\Entity\Campain;
use App\Entity\CampainRegistration;
use App\Entity\Choice;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\Qcm;
use App\Entity\Question;
use App\Entity\User;
use App\Entity\UserQcmResponse;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class StatisticsDashboardController extends AbstractDashboardController
{

    private $security;
    private $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    #[Route('/admin/statistics', name: 'admin_statistics')]
    public function index(): Response
    {
        $user = $this->security->getUser();
        return $this->render('admin/statistics.html.twig', [
            "user"  => $user,
            "response" => $this->spfUsersResponse()
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Wired Beauty');
    }

    public function configureMenuItems(): iterable
    {
    }

    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();

        return $assets
            ->addWebpackEncoreEntry('admin-stats');
    }

    public function getUsersResponse(){
        return $this->em->getRepository(UserQcmResponse::class)->findAll();
    }

    public function spfUsersResponse(){
        $spf15 = 0;
        $spf30 = 0 ;
        $spf50p = 0;
        foreach ($this->getUsersResponse() as $item) {
            $response = json_decode($item->getContent(), true)['question_1']['value'];

            switch ($response){
                case 'PF15':
                    $spf15++;
                    break;
                case 'PF30':
                    $spf30++;
                    break;
                case 'PF50+':
                    $spf50p++;
                    break;
            }
        }
        return $spf15 . ','  . $spf30 . ',' .  $spf50p;
    }
}
