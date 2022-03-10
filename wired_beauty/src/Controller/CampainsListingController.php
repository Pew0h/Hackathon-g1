<?php

namespace App\Controller;

use App\Entity\Qcm;
use App\Entity\Campain;
use App\Entity\UserQcmResponse;
use App\Entity\CampainRegistration;
use App\Repository\CampainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CampainsListingController extends AbstractController
{
    private $em;
    private $security;

    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    #[Route('/campains/listing', name: 'campains_listing')]
    public function index(): Response
    {
        $campains = $this->em->getRepository(Campain::class)->findAll();

        return $this->render('campains_listing/index.html.twig', [
            'controller_name'   => 'CampainsListingController',
            "campains"          => $campains,
            "menu"              => [
                [
                    "title" => "All campains",
                    "class" => "active",
                    "route" => "campains_listing"
                ],
                [
                    "title" => "Subscribed campains",
                    "class" => "",
                    "route" => "campains_subscribed_listing"
                ],
            ]
        ]);
    }

    #[Route('/campains/single', name: 'campains_single')]
    public function campainDetails(Request $request, EntityManagerInterface $entityManager): ?Response
    {
        $error = true;
        $checker = false;
        $status = null;
        $campain = "";
        $campainRegistration = null;
        $form = null;
        $formLength = null;
        $questions = [];

        if (isset($_GET["campain_id"])) {
            $user = $this->security->getUser();
            $campain = $this->em->getRepository(Campain::class)->find($_GET["campain_id"]);

            if ($campain) {
                $error = false;

                if ($user) {
                    foreach ($user->getCampainRegistrations() as $user_reg) {
                        if ($user_reg->getCampain()->getId() == $_GET["campain_id"]) {
                            $checker = true;
                            $campainRegistration = $user_reg;
                            $status = $user_reg->getStatus();
                        }
                    }
                }

                if ($status && $status == 1) {
                    if ($campain->getQcm()) {
                        $userQcmResponse = new UserQcmResponse();
                        $form = $this->createFormBuilder($userQcmResponse);

                        $questions = $campain->getQcm()->getQuestions();
                        $formLength = count($questions);

                        foreach ($questions as $k => $question) {
                            $choices = [];

                            foreach ($question->getChoices() as $choice) {
                                $choices[$choice->getValue()] = $choice->getValue();
                            }

                            $form->add( 'question_' . $k + 1, ChoiceType::class, [
                                'mapped' => false,
                                'label' => $question->getName(),
                                'choices' => $choices
                            ]);
                        }

                        $form = $form->getForm();
                        $form->handleRequest($request);

                        if ($form->isSubmitted()) {
                            $userQcmResponse->setCampainRegistration($campainRegistration);
                            $data = [];

                            for ($i = 1; $i < $formLength; $i++) {
                                $data['question_' . $i] = [
                                    'name' => $questions[$i - 1]->getName(),
                                    'value' => $form->get('question_' . $i)->getData()
                                ];
                            }

                            $userQcmResponse->setContent($data);
                            $campainRegistration->setStatus(2);
                            $entityManager->persist($userQcmResponse);
                            $entityManager->persist($campainRegistration);
                            $entityManager->flush();
                            $status = 2;
                        }
                    }
                }
            }

            if (isset($_GET["register"]) && $_GET["register"] == "true") {
                $this->registerToCampain($_GET["campain_id"]);
            }
        }
        if ($error === false) {

            return $this->render('campains_listing/single.html.twig', [
                'controller_name'   => 'CampainsListingController',
                "campain"           => $campain,
                "already_asked"     => $checker,
                "status"            => $status,
                'form'              => $form ? $form->createView() : $form,
                'formLength'        => $formLength
            ]);
        } else {

            return $this->redirectToRoute('campains_listing');
        }
    }

    #[Route('/campains/Subscribed', name: 'campains_subscribed_listing')]
    public function listSubscribedCampains(): Response
    {
        $user = $this->security->getUser();
        $campains = [];
        foreach ($user->getCampainRegistrations() as $user_reg) {
            $date = $user_reg->getcampain()->getStartDate()->format("d-m-Y");
            $campains[$date . "_" . $user_reg->getCampain()->getId()] = $user_reg->getCampain();
        }
        ksort($campains);

        return $this->render('campains_listing/index.html.twig', [
            'controller_name'   => 'CampainsListingController',
            "campains"          => $campains,
            "menu"              => [
                [
                    "title" => "All campains",
                    "class" => "",
                    "route" => "campains_listing"
                ],
                [
                    "title" => "Subscribed campains",
                    "class" => "active",
                    "route" => "campains_subscribed_listing"
                ],
            ]
        ]);
    }

    public function registerToCampain($id)
    {
        $user = $this->security->getUser();
        $campain = $this->em->getRepository(Campain::class)->find($id);
        if ($campain && $user) {
            $checker = false;
            foreach ($user->getCampainRegistrations() as $user_reg) {
                if ($user_reg->getCampain()->getId() == $id) $checker = true;
            }
            if ($checker === false) {
                $campainRegistration = new CampainRegistration();
                $campainRegistration->setStatus(0)
                    ->setCampain($campain)
                    ->setTester($user);
                $this->em->persist($campainRegistration);
                $this->em->flush($campainRegistration);
            }
        }

        header('Location: /campains/single?campain_id=' . $id);
        exit;
    }
}
