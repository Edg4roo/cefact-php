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
        // Obtener los datos del formulario
        $name = $request->get('name');
        $phone = $request->get('phone');
        $email = $request->get('email');
        $nia = $request->get('nia');

        $tutor = $this->getUser();
        // Crear una nueva instancia de Student y establecer los datos
        $student = new Student();
        $student->setName($name);
        $student->setPhone($phone);
        $student->setEmail($email);
        $student->setNia($nia);
        $student->addTutor($tutor);

        // Manejar el archivo de imagen
        var_dump($request->files->get('student')['imageFile']);
        $imageFile = $request->files->get('student')['imageFile'];
        if ($imageFile) {
            // Generar un nombre único para el archivo
            $fileName = md5(uniqid()).'.'.$imageFile->guessExtension();

            // Mover el archivo al directorio de destino configurado en VichUploaderBundle
            $imageFile->move(
                $this->getParameter('students_directory'), // Directorio de destino configurado en vich_uploader.yaml
                $fileName
            );

            // Actualizar el nombre de la imagen en la entidad Student
            $student->setThumbnail($fileName);
        }

        // Guardar el nuevo alumno en la base de datos
        $entityManager->persist($student);
        $entityManager->flush();

        // Redirigir a la página de éxito o mostrar un mensaje de éxito
        return $this->redirectToRoute('app_tutor_my_students');
    }
}
