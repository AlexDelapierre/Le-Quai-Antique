<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use App\Repository\CouvertRepository;
use App\Repository\ReservationRepository;
use PDO;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JsonController extends AbstractController
{
  #[Route('/nbCouvertsMax')]
  public function getNbCouvertsMax(CouvertRepository $couvertRepository): JsonResponse
  {
    $couverts = $couvertRepository->findAll();
    $nbCouvertsMax = array();
    foreach ($couverts as $key => $couvert) {
      $nbCouvertsMax[$key]['maxCouverts'] = $couvert->getMaxCouverts();
    }

    return new JsonResponse($nbCouvertsMax);  
  }

  #[Route('/nbCouverts', name:'app_nbCouverts')]
  public function getNbCouverts(ReservationRepository $reservationRepository): JsonResponse
  {
   
    /*
    // Avec PDO :
    try {
      $pdo = new PDO('mysql:host=localhost;dbname=restaurant', 'root', '');
      $statement = $pdo->prepare('select SUM(nb_couverts) FROM reservation');
      if ($statement->execute()) {
        while ($data = $statement->fetch(PDO::FETCH_OBJ)) {
        $nbCouverts = $data;  
        }   
      }
    } catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage() . "<br/>";
      die();
    }
    */

     /*
    // Ancienne méthode :
    $em = $this->getDoctrine()->getManager();
    $reservations = $em->getRepository(Reservation::class)->findAll();
    dd($reservations);
    */

    /*
    // Avec finAll() :
    $reservations = $reservationRepository->findAll(); 
    $nbCouverts = array();
    foreach ($reservations as $key => $reservation) {
      $nbCouverts[$key]['nbCouverts'] = $reservation->getNbCouverts();
    }
    */ 

    // Avec requête DQL :
    $nbCouverts = $reservationRepository->findNbCouverts();
    
    return new JsonResponse($nbCouverts);  
  } 
}