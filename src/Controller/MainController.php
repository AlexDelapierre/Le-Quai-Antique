<?php

namespace App\Controller;

use App\Entity\Formule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\GalerieRepository;
use App\Repository\MenuRepository;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
  #[Route('/', name: 'main')]
  public function index(GalerieRepository $galerieRepository): Response
  {
    $galeries = $galerieRepository->findAll();
    // dd($galeries);

    /*
    // On récupère une galerie par son id (ici, 40)
    $galerie = $galerieRepository->find(40);

    // On récupère l'objet Image associé à la galerie
    $image = $galerie->getImage();
    
    // On peut maintenant accéder aux propriétés de l'objet Image
    $filename = $image->getFilename();
    $title = $image->getTitle();
    */
    
    return $this->render('main/index.html.twig', compact('galeries'));
  }

  #[Route('/carte', name: 'carte')]
  public function carte(PlatRepository $platRepository, MenuRepository $menuRepository): Response
  {
    $menus = $menuRepository->findAll();
    $entrees = $platRepository->findAllEntreesOrderedByAsc();
    $plats = $platRepository->findAllPlatsOrderedByAsc();
    $desserts = $platRepository->findAllDessertsOrderedByAsc();
    return $this->render('main/carte.html.twig', compact('entrees', 'plats', 'desserts', 'menus'));
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