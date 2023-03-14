<?php

namespace App\Controller\Admin;

use App\Entity\ConfigSite;
use App\Form\ConfigSiteType;
use App\Repository\ConfigSiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/config_site')]
class ConfigSiteController extends AbstractController
{
    #[Route('/', name: 'app_config_site_index', methods: ['GET'])]
    public function index(ConfigSiteRepository $configSiteRepository): Response
    {
        return $this->render('admin/config_site/index.html.twig', [
            'config_sites' => $configSiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_config_site_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConfigSiteRepository $configSiteRepository): Response
    {
        $configSite = new ConfigSite();
        $form = $this->createForm(ConfigSiteType::class, $configSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $configSiteRepository->save($configSite, true);

            return $this->redirectToRoute('app_config_site_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/config_site/new.html.twig', [
            'config_site' => $configSite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_config_site_show', methods: ['GET'])]
    public function show(ConfigSite $configSite): Response
    {
        return $this->render('admin/config_site/show.html.twig', [
            'config_site' => $configSite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_config_site_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ConfigSite $configSite, ConfigSiteRepository $configSiteRepository): Response
    {
        $form = $this->createForm(ConfigSiteType::class, $configSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $configSiteRepository->save($configSite, true);

            return $this->redirectToRoute('app_config_site_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/config_site/edit.html.twig', [
            'config_site' => $configSite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_config_site_delete', methods: ['POST'])]
    public function delete(Request $request, ConfigSite $configSite, ConfigSiteRepository $configSiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$configSite->getId(), $request->request->get('_token'))) {
            $configSiteRepository->remove($configSite, true);
        }

        return $this->redirectToRoute('app_config_site_index', [], Response::HTTP_SEE_OTHER);
    }
}