<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\TrainingOffer;
use App\Entity\Tutor;
use App\Form\StudentType;
use App\Form\TutorRegistrationFormType;
use App\Form\TutorType;
use App\Repository\CompanyRepository;
use App\Repository\StudentRepository;
use App\Repository\TrainingOfferRepository;
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
    #[Route('/', name: 'app_tutor_search_companies')]
    public function findCompanies(CompanyRepository $companyRepository, TrainingOfferRepository $trainingOfferRepository): Response
    {
        $trainingOffers = $trainingOfferRepository->findAll();
        return $this->render('tutor/search_companies.html.twig', [
            'trainingOffers' => $trainingOffers
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

    #[Route('/students', name: 'app_tutor_my_students')]
    public function showStudents(Request $request, StudentRepository $studentRepository): Response
    {
        $tutor = $this->getUser();
        $student = new Student();
        $students = $tutor->getStudents();
        $student_form = $this->createForm(StudentType::class, $student);
        $student_form->handleRequest($request);

        if ($student_form->isSubmitted() && $student_form->isValid()) {
            $student->addTutor($tutor);
            $studentRepository->save($student,true);
            return $this->redirectToRoute('app_tutor_my_students', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tutor/my_students.html.twig', [
            'studentForm' => $student_form,
            'students' => $students
        ]);
    }

}
