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

        if (!$request) {
            throw $this->createNotFoundException('La solicitud no existe.');
        }

        $training = new Training();
        $company_representative = $request->getCompany()->getCompanyRepresentatives();
        $training->setCompanyRepresentative($company_representative[0]);
        $training->setStudent($request->getStudentOffer()->getStudent());
        $training->setTutor($this->getUser());
        $training->setCompany($request->getCompany());
        $training->setStartDate(new \DateTime());

        $entityManager->persist($training);
        $entityManager->flush();

        $request->setStatus('accepted');

        $entityManager->flush();

        return $this->redirectToRoute('app_tutor_request_received');
    }

    #[Route('/deny/{id}', name: 'app_request_deny')]
    public function denyOffer(Request $request, EntityManagerInterface $entityManager, RequestRepository $requestRepository, $id): Response
    {
        $request = $requestRepository->find($id);

        if (!$request) {
            throw $this->createNotFoundException('La solicitud no existe.');
        }

        $request->setStatus('denied');
        $entityManager->flush();

        return $this->redirectToRoute('app_tutor_request_received');
    }
}
