<?php

namespace App\Controller\Admin;

use App\Entity\Couvert;
use App\Form\CouvertType;
use App\Repository\CouvertRepository;
use App\Repository\HoraireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/couvert')]
class CouvertController extends AbstractController
{
    #[Route('/', name: 'app_couvert_index', methods: ['GET'])]
    public function index(CouvertRepository $couvertRepository, HoraireRepository $horaireRepository): Response
    {
        return $this->render('admin/couvert/index.html.twig', [
            'couverts' => $couvertRepository->findAll(),
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_couvert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CouvertRepository $couvertRepository, HoraireRepository $horaireRepository): Response
    {
        $couvert = new Couvert();
        $form = $this->createForm(CouvertType::class, $couvert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $couvertRepository->save($couvert, true);

            return $this->redirectToRoute('app_couvert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/couvert/new.html.twig', [
            'couvert' => $couvert,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_couvert_show', methods: ['GET'])]
    public function show(Couvert $couvert, HoraireRepository $horaireRepository): Response
    {
        return $this->render('admin/couvert/show.html.twig', [
            'couvert' => $couvert,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_couvert_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Couvert $couvert, CouvertRepository $couvertRepository, HoraireRepository $horaireRepository): Response
    {
        $form = $this->createForm(CouvertType::class, $couvert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $couvertRepository->save($couvert, true);

            return $this->redirectToRoute('app_couvert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/couvert/edit.html.twig', [
            'couvert' => $couvert,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_couvert_delete', methods: ['POST'])]
    public function delete(Request $request, Couvert $couvert, CouvertRepository $couvertRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$couvert->getId(), $request->request->get('_token'))) {
            $couvertRepository->remove($couvert, true);
        }

        return $this->redirectToRoute('app_couvert_index', [], Response::HTTP_SEE_OTHER);
    }
}