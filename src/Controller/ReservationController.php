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
    public function new(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class);
        $form->handleRequest($request);

        // $reservation->setUser($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            print_r($data);

            echo '<br>';

            $lastname = $data['lastname'];
            $firstname = $data['firstname'];
            $phoneNumber = $data['phoneNumber'];
            $nbCouverts = $data['nbCouverts'];
            
            //On crée une variable de type string qui contient la date, l'heure et le timezone.
            $date = $data['date']->format('m/d/Y');
            $time = $data['time'];
            $timezone = 'GMT';
            $dateString = $date.' '.$time.' '.$timezone;

            echo($dateString);
            echo '<br>';

            //Pour convertir une string en objet dateTime :
            $dateTime = DateTime::createfromformat('m/d/Y H:i:s e',$dateString);   

            // echo $dateTime->format('Y-m-d H:i:s e');

            $reservation->setLastname($lastname);
            $reservation->setFirstname($firstname);
            $reservation->setPhoneNumber($phoneNumber);
            $reservation->setnbCouverts($nbCouverts);
            $reservation->setDateTime($dateTime);
            
                        

            // $dateString = 'Wed, 28 Dec 2011 13:04:30 GMT';
            // $dateTime = DateTime::createfromformat('D, d M Y H:i:s e',$dateString);      
            // echo $dateTime->format('d-M-Y H:i:s e');

            // $date = new DateTime('2000-01-01');
            // $result = $date->format('Y-m-d H:i:s'); 



          

            
        
            //Pour convertir une string en objet dateTime :
            // $dateTime = strtotime($date.' '.$time);
            // echo date('d/M/Y H:i', $dateTime);
            
            
           

            // print_r($dateTime);

            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
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
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
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