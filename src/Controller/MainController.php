<?php

namespace App\Controller;

use App\Entity\Formule;
use App\Entity\Horaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\GalerieRepository;
use App\Repository\HoraireRepository;
use App\Repository\MenuRepository;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{ 
  #[Route('/', name: 'main')]
  public function index(GalerieRepository $galerieRepository, HoraireRepository $horaireRepository): Response
  {
    $galeries = $galerieRepository->findAll();
    $horaires = $horaireRepository->findAll();
    /*
    // On récupère une galerie par son id (ici, 40)
    $galerie = $galerieRepository->find(40);

    // On récupère l'objet Image associé à la galerie
    $image = $galerie->getImage();
    
    // On peut maintenant accéder aux propriétés de l'objet Image
    $filename = $image->getFilename();
    $title = $image->getTitle();
    */
    
    return $this->render('main/index.html.twig', compact('galeries', 'horaires'));
  }

  #[Route('/carte', name: 'carte')]
  public function carte(PlatRepository $platRepository, MenuRepository $menuRepository, HoraireRepository $horaireRepository): Response
  {
    $menus = $menuRepository->findAll();
    $entrees = $platRepository->findAllEntreesOrderedByAsc();
    $plats = $platRepository->findAllPlatsOrderedByAsc();
    $desserts = $platRepository->findAllDessertsOrderedByAsc();
    $horaires = $horaireRepository->findAll();
    return $this->render('main/carte.html.twig', compact('entrees', 'plats', 'desserts', 'menus', 'horaires'));
  }

  #[Route('/contact', name: 'contact')]
  public function contact(HoraireRepository $horaireRepository): Response
  {
    $horaires = $horaireRepository->findAll();
    return $this->render('main/contact.html.twig', compact('horaires'));
  }

  #[Route('/base', name: 'base')]
  public function base(GalerieRepository $galerieRepository, HoraireRepository $horaireRepository): Response
  {
    $horaires = $horaireRepository->findAll();
    
    return $this->render('base.html.twig', compact('horaires'));
  }
  
  #[Route('/footer', name: 'footer')]
  public function footer(GalerieRepository $galerieRepository, HoraireRepository $horaireRepository): Response
  {
    $horaires = $horaireRepository->findAll();
    
    return $this->render('_partials/_footer.html.twig', compact('horaires'));
  }
}