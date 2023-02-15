<?php

namespace App\Controller;

use App\Entity\ServiceSoir;
use App\Form\ServiceSoirType;
use App\Repository\ServiceSoirRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/soir')]
class ServiceSoirController extends AbstractController
{
    #[Route('/', name: 'app_service_soir_index', methods: ['GET'])]
    public function index(ServiceSoirRepository $serviceSoirRepository): Response
    {
        return $this->render('service_soir/index.html.twig', [
            'service_soirs' => $serviceSoirRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_soir_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceSoirRepository $serviceSoirRepository): Response
    {
        $serviceSoir = new ServiceSoir();
        $form = $this->createForm(ServiceSoirType::class, $serviceSoir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceSoirRepository->save($serviceSoir, true);

            return $this->redirectToRoute('app_service_soir_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_soir/new.html.twig', [
            'service_soir' => $serviceSoir,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_soir_show', methods: ['GET'])]
    public function show(ServiceSoir $serviceSoir): Response
    {
        return $this->render('service_soir/show.html.twig', [
            'service_soir' => $serviceSoir,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_soir_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceSoir $serviceSoir, ServiceSoirRepository $serviceSoirRepository): Response
    {
        $form = $this->createForm(ServiceSoirType::class, $serviceSoir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceSoirRepository->save($serviceSoir, true);

            return $this->redirectToRoute('app_service_soir_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_soir/edit.html.twig', [
            'service_soir' => $serviceSoir,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_soir_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceSoir $serviceSoir, ServiceSoirRepository $serviceSoirRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceSoir->getId(), $request->request->get('_token'))) {
            $serviceSoirRepository->remove($serviceSoir, true);
        }

        return $this->redirectToRoute('app_service_soir_index', [], Response::HTTP_SEE_OTHER);
    }
}
