<?php

namespace App\Controller;

use App\Entity\Tutor;
use App\Form\TutorFormType;
use App\Form\TutorRegistrationFormType;
use App\Form\TutorType;
use App\Repository\TutorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tutor')]
class TutorController extends AbstractController
{
    #[Route('/', name: 'app_tutor')]
    public function index(): Response
    {
        return $this->render('tutor/index.html.twig', [
            'controller_name' => 'TutorController',
        ]);
    }

    #[Route('/register', name: 'app_tutor_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $tutor = new Tutor();
        $form = $this->createForm(TutorRegistrationFormType::class, $tutor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // e
            $tutor->setPassword(
                $userPasswordHasher->hashPassword(
                    $tutor,
                    $form->get('plainPassword')->getData()
                )
            );
            $study_center = $form ->get('studyCenters')->getData();
            $tutor->setStudyCenter($study_center);
            $entityManager->persist($tutor);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('tutor/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

}
