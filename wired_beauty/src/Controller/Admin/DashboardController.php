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
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractDashboardController
{

    /**
     * @var Security
     */
    private $security;

    private EntityManagerInterface $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $user = $this->security->getUser();
        if ($user) {
            if ($user->checkRole($user, "ROLE_ADMIN")) {

                $users_dashboard = $this->em->getRepository(User::class)->findAll();
                $companies_dashboard = $this->em->getRepository(Company::class)->findAll();
                $products_dashboard = $this->em->getRepository(Product::class)->findAll();

                $campains_dashboard = $this->em->getRepository(Campain::class)->findAll();
                $campainsRegistration_dashboard = $this->em->getRepository(CampainRegistration::class)->findAll();
                $surveyAnswer_dashboard = $this->em->getRepository(UserQcmResponse::class)->findAll();

                $questions_dashboard = $this->em->getRepository(Question::class)->findAll();
                $surveys_dashboard = $this->em->getRepository(Qcm::class)->findAll();
                $choices_dashboard = $this->em->getRepository(Choice::class)->findAll();

                return $this->render('admin/dashboard.html.twig', [
                    "user"  => $user,
                    "entities" => [
                        "users" => $users_dashboard,
                        "companies" => $companies_dashboard,
                        "products" => $products_dashboard,
                    ],
                    "campains" => [
                        "campains"  => $campains_dashboard,
                        "registrations" => $campainsRegistration_dashboard,
                        "survey_answer" => $surveyAnswer_dashboard,
                    ],
                    "questions" => [
                        "surveys" => $surveys_dashboard,
                        "questions"  => $questions_dashboard,
                        "choices" => $choices_dashboard,
                    ]
                ]);
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
            // ->renderContentMaximized()

            // by default, all backend URLs are generated as absolute URLs. If you
            // need to generate relative URLs instead, call this method
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud("Users", "fa fa-users", User::class);
        yield MenuItem::linkToCrud("Companies", "fa fa-building", Company::class);
        yield MenuItem::linkToCrud("Products", "fa fa-cubes", Product::class);
        yield MenuItem::section();
        yield MenuItem::subMenu("Campains", "fa fa-chart-bar")->setSubItems([
            MenuItem::linkToCrud("Campains list", "fa fa-chart-bar", Campain::class),
            MenuItem::linkToCrud("Campains Registration", "fa fa-registered", CampainRegistration::class),
            MenuItem::linkToCrud("Survey Answers", "fa fa-voicemail", UserQcmResponse::class),
        ]);
        yield MenuItem::section();
        yield MenuItem::subMenu("Questions", "fa fa-chart-bar")->setSubItems([
            MenuItem::linkToCrud("Survey list", "fa fa-chart-bar", Qcm::class),
            MenuItem::linkToCrud("Question list", "fa fa-chart-bar", Question::class),
            MenuItem::linkToCrud("Choices list", "fa fa-chart-bar", Choice::class),
        ]);
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
