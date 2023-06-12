<?php

namespace App\Controller;

use App\Repository\TrainingOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute("home");
    }

    #[Route('/home', name: 'home', priority:1)]
    public function home(TrainingOfferRepository $trainingOfferRepository): Response
    {
        $trainingOffers = $trainingOfferRepository->findAll();
        if ($this->isGranted('ROLE_TUTOR')) {
            return $this->redirectToRoute("app_tutor_search_companies");
        }
            return $this->render('home/fe-home.html.twig',[
                'trainingOffers' => $trainingOffers
            ]);

    }
}
