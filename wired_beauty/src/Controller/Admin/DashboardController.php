<?php

namespace App\Controller\Admin;

use App\Entity\Campain;
use App\Entity\CampainRegistration;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\Question;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractDashboardController {
    
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response {
        $user = $this->security->getUser();
        if ($user) {
            if ($user->checkRole($user, "ROLE_ADMIN")) {
                return $this->render('admin/dashboard.html.twig');
            } else {
                return $this->redirectToRoute('index');
            }
        } else {
            return $this->redirectToRoute('login');
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle("Wired Beauty")

            // there's no need to define the "text direction" explicitly because
            // its default value is inferred dynamically from the user locale
            ->setTextDirection('ltr')

            // by default, all backend URLs include a signature hash. If a user changes any
            // query parameter (to "hack" the backend) the signature won't match and EasyAdmin
            // triggers an error. If this causes any issue in your backend, call this method
            // to disable this feature and remove all URL signature checks
            ->disableUrlSignatures()
            ->renderContentMaximized()

            // by default, all backend URLs are generated as absolute URLs. If you
            // need to generate relative URLs instead, call this method
            ->generateRelativeUrls()
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud("Utilisateurs", "fa fa-users", User::class);
        yield MenuItem::linkToCrud("Sociétés", "fa fa-building", Company::class);
        yield MenuItem::linkToCrud("Produits", "fa fa-cubes", Product::class);
        yield MenuItem::section();
        yield MenuItem::subMenu("Campains", "fa fa-chart-bar")->setSubItems([
            MenuItem::linkToCrud("Campains list", "fa fa-chart-bar", Campain::class),
            MenuItem::linkToCrud("Question list", "fa fa-chart-bar", Question::class),
            MenuItem::linkToCrud("Campains Registration", "fa fa-registered", CampainRegistration::class)
        ]);

    }

    public function configureAssets(): Assets{
        $assets = parent::configureAssets();

        return $assets
            ->addWebpackEncoreEntry('admin-app')
            ->addJsFile('build/admin-app.js');
            // ->addCssFile('build/admin-app.scss');
            
    }
}
