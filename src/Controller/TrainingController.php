<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/training')]
class TrainingController extends AbstractController
{
    #[Route('/trainings', name: 'app_show_trainings')]
    public function showTutorTrainings()
    {
        $tutor = $this->getUser();

        if ($tutor->getTrainings()->count() > 0) {
            $trainings = $tutor->getTrainings();

            return $this->render('training/show_trainings.html.twig', [
                'trainings' => $trainings,
            ]);
        }

        return $this->redirectToRoute('home');
    }
}
