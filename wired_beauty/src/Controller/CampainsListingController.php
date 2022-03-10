<?php

namespace App\Controller;

use App\Entity\Campain;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampainsListingController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/campains/listing', name: 'campains_listing')]
    public function index(): Response
    {
        $campains = $this->em->getRepository(Campain::class)->findBy([
            "startDate" => "> current_timestamp()",
        ]);
        return $this->render('campains_listing/index.html.twig', [
            'controller_name'   => 'CampainsListingController',
            "campains"          => $campains,
        ]);
    }

    #[Route('/campains/Subscribed', name: 'campains_subscribed_listing')]
    public function listSubscribedCampains(): Response
    {

        return $this->render('campains_listing/index.html.twig', [
            'controller_name' => 'CampainsListingController',
        ]);
    }
}
