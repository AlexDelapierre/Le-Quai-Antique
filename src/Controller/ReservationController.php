<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {      
        // if ($this->getUser()){
        //     $userRole = $this->getUser()->getRoles();
            
        //     if(in_array("ROLE_ADMIN", $userRole)){
        //         return $this->render('admin/reservationAdmin/index.html.twig', [
        //             'reservations' => $reservationRepository->findAll(),
        //         ]);
        //     } 
        //     else {
        //         return $this->render('reservation/index.html.twig', [
        //             'reservations' => $reservationRepository->findAll(),
        //         ]);
        //     } 
        // }

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 

            // var_dump($_POST);
            // die();
            
            $lastname = test_input($_POST["lastname"]);
            $firstname = test_input($_POST["firstname"]);
            $phoneNumber = test_input($_POST["phoneNumber"]);
            $nbCouverts = test_input($_POST["nbCouverts"]);
            $date = test_input($_POST["date"]);
            $service = test_input($_POST["service"]);        
            $comments = test_input($_POST["comments"]);
        
            //On crée une variable $dateTime de type string qui contient la date, l'heure et la timezone.
            $timezone = 'GMT';
            if( $_POST["service"] === "midi") {
                $midi = test_input($_POST["midi"]);
                $dateTimeString = $date.' '.$midi.' '.$timezone;
            } else {
                $soir = test_input($_POST["soir"]);
                $dateTimeString = $date.' '.$soir.' '.$timezone;
            };

            //Pour convertir une string en objet dateTime :
            $dateTime = DateTime::createfromformat('Y-m-d H:i:s e',$dateTimeString);
            
            $reservation->setLastname($lastname);
            $reservation->setFirstname($firstname);
            $reservation->setPhoneNumber($phoneNumber);
            $reservation->setnbCouverts($nbCouverts);
            $reservation->setDateTime($dateTime);
            $reservation->setService($service);
            $reservation->setComments($comments);
          
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);    
        }
           
        return $this->renderForm('reservation/new.html.twig', [
            // 'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        // print_r($reservation);        

        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            
            $lastname = test_input($_POST["lastname"]);
            $firstname = test_input($_POST["firstname"]);
            $phoneNumber = test_input($_POST["phoneNumber"]);
            $nbCouverts = test_input($_POST["nbCouverts"]);
            $date = test_input($_POST["date"]);
            $service = test_input($_POST["service"]);        
            $comments = test_input($_POST["comments"]);
        
            //On crée une variable $dateTime de type string qui contient la date, l'heure et la timezone.
            $timezone = 'GMT';
            if( $_POST["service"] === "midi") {
                $midi = test_input($_POST["midi"]);
                $dateTimeString = $date.' '.$midi.' '.$timezone;
            } else {
                $soir = test_input($_POST["soir"]);
                $dateTimeString = $date.' '.$soir.' '.$timezone;
            };

            //Pour convertir une string en objet dateTime :
            $dateTime = DateTime::createfromformat('Y-m-d H:i:s e',$dateTimeString);
            
            $reservation->setLastname($lastname);
            $reservation->setFirstname($firstname);
            $reservation->setPhoneNumber($phoneNumber);
            $reservation->setnbCouverts($nbCouverts);
            $reservation->setDateTime($dateTime);
            $reservation->setService($service);
            $reservation->setComments($comments);
          
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);    
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}