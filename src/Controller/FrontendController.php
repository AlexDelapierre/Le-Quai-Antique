<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
  /**
   * @Route("/", name = "index")
   * 
   * @return Response
   */
  public function index(): Response
  {
    return $this->render('frontend/homepage.html.twig', ['name' => '']);
  }

  /**
   * @Route("/carte", name = "carte")
   */
  public function carte (): Response
  {
    return $this->render('frontend/carte.html.twig', ['name' => '']);
  }

  /**
   * @Route("/reservation", name = "reservation")
   */
  public function reservation(): Response
  {
    return $this->render('frontend/reservation.html.twig', ['name' => '']);
  }

  /**
   * @Route("/contact", name = "contact")
   */
  public function contact(): Response
  {
    return $this->render('frontend/contact.html.twig', ['name' => '']);
  }
}