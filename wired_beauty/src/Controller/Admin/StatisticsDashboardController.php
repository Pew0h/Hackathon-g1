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

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/admin/statistics', name: 'admin_statistics')]
    public function index(): Response
    {
        $user = $this->security->getUser();
        return $this->render('admin/statistics.html.twig', [
            "user"  => $user,
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
            ->addWebpackEncoreEntry('admin-app')
            ->addJsFile('build/admin-app.js');
        // ->addCssFile('build/admin-app.scss');

    }
}
