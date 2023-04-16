<?php

namespace App\Controller\Admin;

use App\Repository\HoraireRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(HoraireRepository $horaireRepository,UserRepository $userRepository): Response
    {
        return $this->render('admin/index.html.twig' ,[
            'horaires' => $horaireRepository->findAll(),
            'adminUsers' => $userRepository->findAdminUsers(),
        ]);

    }
}