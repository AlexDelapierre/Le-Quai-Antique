<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
  #[Route('/NbCouverts', name: 'app_reservation_essai')]
  public function getNbCouverts(ReservationRepository $reservationRepository): JsonResponse
  {
    // // Ancienne méthode :
    // $em = $this->getDoctrine()->getManager();
    // $nbCouverts = $em->getRepository(Reservation::class)->findAll();
  
    // $nbCouverts = $reservationRepository->findAll();
    
    // $data = array();
    // foreach ($nbCouverts as $key => $nbCouvert) {
    //   $data[$key]['nbCouverts'] = $nbCouvert->getNbCouverts();
    // } 
  
    // $nbCouverts = $reservationRepository->findNbCouverts();
  
    // echo $nbCouverts;
    // die();
  
    $pdo = new PDO('mysql:host=localhost;dbname=restaurant', 'root', '');
    $statement = $pdo->prepare('select SUM(nb_couverts) FROM reservation');
    if ($statement->execute()) {
      while ($data = $statement->fetch(PDO::FETCH_OBJ)) {
      $nbCouverts = $data;  
      }   
    }
    return new JsonResponse($nbCouverts); 
  }  
}