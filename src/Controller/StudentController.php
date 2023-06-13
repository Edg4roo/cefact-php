<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/new', name: 'app_student_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentRepository $studentRepository, EntityManagerInterface $entityManager): Response
    {
        $name = $request->get('name');
        $phone = $request->get('phone');
        $email = $request->get('email');
        $nia = $request->get('nia');

        $tutor = $this->getUser();

        $student = new Student();
        $student->setName($name);
        $student->setPhone($phone);
        $student->setEmail($email);
        $student->setNia($nia);
        $student->addTutor($tutor);

        $imageFile = $request->files->get('student')['imageFile'];
        if ($imageFile) {
            // Generar un nombre único para el archivo
            $fileName = md5(uniqid()).'.'.$imageFile->guessExtension();


            $imageFile->move(
                $this->getParameter('students_directory'), // Directorio de destino configurado en vich_uploader.yaml
                $fileName
            );


            $student->setThumbnail($fileName);
        }


        $entityManager->persist($student);
        $entityManager->flush();


        return $this->redirectToRoute('app_tutor_my_students');
    }
}
