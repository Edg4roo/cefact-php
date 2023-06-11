<?php

namespace App\Controller;

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
    public function home(): Response
    {
        if ($this->isGranted('ROLE_TUTOR')) {
            return $this->redirectToRoute("app_tutor_search_companies");
        }
            return $this->render('home/fe-home.html.twig', [
                'controller_name' => 'DefaultController',
            ]);

    }
}
