<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\GalerieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
  #[Route('/', name: 'main')]
  public function index(GalerieRepository $galerieRepository): Response
  {
    $galerie = $galerieRepository->findAll();

    return $this->render('main/index.html.twig', compact('galerie'));
  }

  #[Route('/carte', name: 'carte')]
  public function carte(): Response
  {
    return $this->render('main/carte.html.twig', ['name' => '']);
  }

  #[Route('/reservations', name: 'reservations')]
  public function reservation(): Response
  {
    return $this->render('main/reservation.html.twig', ['name' => '']);
  }

  #[Route('/contact', name: 'contact')]
  public function contact(): Response
  {
    return $this->render('main/contact.html.twig', ['name' => '']);
  }
}