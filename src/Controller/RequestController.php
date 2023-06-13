<?php

namespace App\Controller;

use App\Entity\Request;
use App\Entity\Training;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/request')]
class RequestController extends AbstractController
{
    #[Route('/accept/{id}', name: 'app_request_accept')]
    public function acceptOffer(Request $request, EntityManagerInterface $entityManager, RequestRepository $requestRepository, $id): Response
    {
        $request = $requestRepository->find($id);

        // Verificar que la solicitud existe
        if (!$request) {
            throw $this->createNotFoundException('La solicitud no existe.');
        }

        // Realizar acciones de aceptación
        // ...

        // Crear una nueva entidad Training
        $training = new Training();
        $company_representative = $request->getCompany()->getCompanyRepresentatives();
        $training->setCompanyRepresentative($company_representative[0]);
        $training->setStudent($request->getStudentOffer()->getStudent());
        $training->setTutor($this->getUser());
        $training->setCompany($request->getCompany());
        $training->setStartDate(new \DateTime());

        // Guardar la entidad Training en la base de datos
        $entityManager->persist($training);
        $entityManager->flush();

        // Eliminar la solicitud aceptada
        $request->setStatus('accepted');

        // Guardar los cambios en la base de datos
        $entityManager->flush();

        // Redireccionar a la página de éxito
        return $this->redirectToRoute('app_tutor_request_received');
    }

    /*#[Route('/deny/{id}', name: 'app_tutor_deny_offer')]
    public function denyOffer(Request $request, EntityManagerInterface $entityManager, RequestRepository $requestRepository): Response
    {
        $request = $requestRepository->find($id);

        // Verificar que la solicitud existe
        if (!$request) {
            throw $this->createNotFoundException('La solicitud no existe.');
        }

        // Realizar acciones de denegación
        // ...

        // Eliminar la solicitud denegada
        $entityManager->remove($request);
        $entityManager->flush();

        // Redireccionar a la página de éxito
        return $this->redirectToRoute('app_tutor_success');
    }*/
}
