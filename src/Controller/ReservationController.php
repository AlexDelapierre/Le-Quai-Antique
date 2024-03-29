<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\HoraireRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository, HoraireRepository $horaireRepository): Response
    {
        /*
        if ($this->getUser()){
            $userRole = $this->getUser()->getRoles();
 
            if(in_array("ROLE_ADMIN", $userRole)){
                return $this->render('admin/reservationAdmin/index.html.twig', [
                    'reservations' => $reservationRepository->findAll(),
                    'horaires' => $horaireRepository->findAll(),
                ]);
            } 
            else {
                return $this->render('main/index.html.twig', compact('galeries', 'horaires'));
            } 
        }

        return $this->render('main/index.html.twig', compact('galeries', 'horaires'));
        */

        return $this->render('admin/reservationAdmin/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository, HoraireRepository $horaireRepository): Response
    {
        $reservation = new Reservation();

        // Pré-remplie les données du formulaire
        if ($this->getUser()){
            // Récupérer l'utilisateur actuellement authentifié
            $user = $this->getUser();
            $userRole = $this->getUser()->getRoles();

            if(!in_array("ROLE_ADMIN", $userRole)){
                // Pré-remplissage du formulaire avec les données de l'utilisateur connecté
                $reservation->setLastname($user->getLastname());
                $reservation->setFirstname($user->getFirstname());
                $reservation->setPhoneNumber($user->getPhoneNumber());
                $reservation->setNbCouverts($user->getNbCouverts());
                $reservation->setComments($user->getAllergie());
            }
            
        }; 

        /*
        // Pré-remplie les données du formulaire avec $form
        $form->setData(['lastname' => $user->getLastname(), 'firstname' => $user->getFirstname(),
        'phoneNumber' => $user->getPhoneNumber()]);
        */    
            

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        /*
        // dd(
        //     $form->get('lastname')->getData(),  //Données de modèle
        //     $form->get('lastname')->getNormData(), //Données de normalisation
        //     $form->get('lastname')->getViewData(), //Données de vue
        // );
        */

        if ($form->isSubmitted() && $form->isValid()) {

            /*
            // dd($form->getData());
            // dd($form->get('lastname')); 
            // dd($form->get('lastname')->getName()->getConfig()->getType()->getInnerType());
            */
            
            if ($this->getUser()){
                $reservation->setUser($user);
            }

            $reservationRepository->save($reservation, true);

            $this->addFlash('success', 'Votre réservation est enregistrée');

            //On vérifie si l'utilisateur est connecté et si c'est l'administrateur
            if ($this->getUser()){
                $userRole = $this->getUser()->getRoles();
     
                if(in_array("ROLE_ADMIN", $userRole)){
                    return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
                } 
                /*
                // else {
                //     return $this->render('main/index.html.twig', compact('galeries', 'horaires'));
                // } 
                */
            }

            return $this->redirectToRoute('main', [], Response::HTTP_SEE_OTHER);
        }

        if ($this->getUser()){
            $userRole = $this->getUser()->getRoles();
            if(in_array("ROLE_ADMIN", $userRole)){
                return $this->renderForm('admin/reservationAdmin/new.html.twig', [
                'reservation' => $reservation,
                'form' => $form,
                'horaires' => $horaireRepository->findAll(),
                ]);
            } 
            else {
                return $this->renderForm('reservation/new.html.twig', [
                    'reservation' => $reservation,
                    'form' => $form,
                    'horaires' => $horaireRepository->findAll(),
                ]);
            } 
        }; 

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
           
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation, HoraireRepository $horaireRepository): Response
    {
        return $this->render('admin/reservationAdmin/index.html.twig', [
            'reservation' => $reservation,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository, HoraireRepository $horaireRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/reservationAdmin/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
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