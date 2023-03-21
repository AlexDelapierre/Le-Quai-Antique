<?php

namespace App\Controller;

use App\Entity\Couvert;
use App\Form\CouvertType;
use App\Repository\CouvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/couvert')]
class CouvertController extends AbstractController
{
    #[Route('/', name: 'app_couvert_index', methods: ['GET'])]
    public function index(CouvertRepository $couvertRepository): Response
    {
        return $this->render('couvert/index.html.twig', [
            'couverts' => $couvertRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_couvert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CouvertRepository $couvertRepository): Response
    {
        $couvert = new Couvert();
        $form = $this->createForm(CouvertType::class, $couvert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $couvertRepository->save($couvert, true);

            return $this->redirectToRoute('app_couvert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('couvert/new.html.twig', [
            'couvert' => $couvert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_couvert_show', methods: ['GET'])]
    public function show(Couvert $couvert): Response
    {
        return $this->render('couvert/show.html.twig', [
            'couvert' => $couvert,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_couvert_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Couvert $couvert, CouvertRepository $couvertRepository): Response
    {
        $form = $this->createForm(CouvertType::class, $couvert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $couvertRepository->save($couvert, true);

            return $this->redirectToRoute('app_couvert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('couvert/edit.html.twig', [
            'couvert' => $couvert,
            'form' => $form,
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
