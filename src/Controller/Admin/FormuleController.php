<?php

namespace App\Controller\Admin;

use App\Entity\Formule;
use App\Form\FormuleType;
use App\Repository\FormuleRepository;
use App\Repository\HoraireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formule')]
class FormuleController extends AbstractController
{
    #[Route('/', name: 'app_formule_index', methods: ['GET'])]
    public function index(FormuleRepository $formuleRepository, HoraireRepository $horaireRepository): Response
    {
        return $this->render('admin/formule/index.html.twig', [
            'formules' => $formuleRepository->findAll(),
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormuleRepository $formuleRepository, HoraireRepository $horaireRepository): Response
    {
        $formule = new Formule();
        $form = $this->createForm(FormuleType::class, $formule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formuleRepository->save($formule, true);

            return $this->redirectToRoute('app_formule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/formule/new.html.twig', [
            'formule' => $formule,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_formule_show', methods: ['GET'])]
    public function show(Formule $formule, HoraireRepository $horaireRepository): Response
    {
        return $this->render('admin/formule/show.html.twig', [
            'formule' => $formule,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formule $formule, FormuleRepository $formuleRepository, HoraireRepository $horaireRepository): Response
    {
        $form = $this->createForm(FormuleType::class, $formule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formuleRepository->save($formule, true);

            return $this->redirectToRoute('app_formule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/formule/edit.html.twig', [
            'formule' => $formule,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_formule_delete', methods: ['POST'])]
    public function delete(Request $request, Formule $formule, FormuleRepository $formuleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formule->getId(), $request->request->get('_token'))) {
            $formuleRepository->remove($formule, true);
        }

        return $this->redirectToRoute('app_formule_index', [], Response::HTTP_SEE_OTHER);
    }
}