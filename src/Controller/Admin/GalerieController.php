<?php

namespace App\Controller\Admin;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Repository\GalerieRepository;
use App\Repository\HoraireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/galerie')]
class GalerieController extends AbstractController
{
    #[Route('/', name: 'app_galerie_index', methods: ['GET'])]
    public function index(GalerieRepository $galerieRepository, HoraireRepository $horaireRepository): Response
    {
        return $this->render('admin/galerie/index.html.twig', [
            'galeries' => $galerieRepository->findAllOrderedByIdAsc(),
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_galerie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GalerieRepository $galerieRepository, HoraireRepository $horaireRepository): Response
    {
        $galerie = new Galerie();
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galerieRepository->save($galerie, true);

            return $this->redirectToRoute('app_galerie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/galerie/new.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_galerie_show', methods: ['GET'])]
    public function show(Galerie $galerie, HoraireRepository $horaireRepository): Response
    {
        return $this->render('admin/galerie/show.html.twig', [
            'galerie' => $galerie,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_galerie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Galerie $galerie, GalerieRepository $galerieRepository, HoraireRepository $horaireRepository): Response
    {
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galerieRepository->save($galerie, true);

            return $this->redirectToRoute('app_galerie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/galerie/edit.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_galerie_delete', methods: ['POST'])]
    public function delete(Request $request, Galerie $galerie, GalerieRepository $galerieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galerie->getId(), $request->request->get('_token'))) {
            $galerieRepository->remove($galerie, true);
        }

        return $this->redirectToRoute('app_galerie_index', [], Response::HTTP_SEE_OTHER);
    }
}