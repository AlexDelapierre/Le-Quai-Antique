<?php

namespace App\Controller;

use App\Entity\ServiceMidi;
use App\Form\ServiceMidiType;
use App\Repository\ServiceMidiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/midi')]
class ServiceMidiController extends AbstractController
{
    #[Route('/', name: 'app_service_midi_index', methods: ['GET'])]
    public function index(ServiceMidiRepository $serviceMidiRepository): Response
    {
        return $this->render('service_midi/index.html.twig', [
            'service_midis' => $serviceMidiRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_midi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceMidiRepository $serviceMidiRepository): Response
    {
        $serviceMidi = new ServiceMidi();
        $form = $this->createForm(ServiceMidiType::class, $serviceMidi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceMidiRepository->save($serviceMidi, true);

            return $this->redirectToRoute('app_service_midi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_midi/new.html.twig', [
            'service_midi' => $serviceMidi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_midi_show', methods: ['GET'])]
    public function show(ServiceMidi $serviceMidi): Response
    {
        return $this->render('service_midi/show.html.twig', [
            'service_midi' => $serviceMidi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_midi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceMidi $serviceMidi, ServiceMidiRepository $serviceMidiRepository): Response
    {
        $form = $this->createForm(ServiceMidiType::class, $serviceMidi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceMidiRepository->save($serviceMidi, true);

            return $this->redirectToRoute('app_service_midi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_midi/edit.html.twig', [
            'service_midi' => $serviceMidi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_midi_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceMidi $serviceMidi, ServiceMidiRepository $serviceMidiRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceMidi->getId(), $request->request->get('_token'))) {
            $serviceMidiRepository->remove($serviceMidi, true);
        }

        return $this->redirectToRoute('app_service_midi_index', [], Response::HTTP_SEE_OTHER);
    }
}
