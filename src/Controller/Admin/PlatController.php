<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use App\Service\PictureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/plat')]
class PlatController extends AbstractController
{
    #[Route('/', name: 'app_plat_index', methods: ['GET'])]
    public function index(PlatRepository $platRepository): Response
    {
        return $this->render('admin/plat/index.html.twig', [
            'plats' => $platRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_plat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlatRepository $platRepository, PictureService $pictureService): Response
    {
        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //On récupère les images
            $image = $form->get('image')->getData();
            
            //On défini le dossier de destination
            $folder = 'plats';

            //On appelle le service d'ajout
            $fichier = $pictureService->add($image, $folder, 300, 300);
            
            $img = new Image;
            $img->setName($fichier);

            //On persiste notre image dans le plat
            $plat->setImage($img);


            $platRepository->save($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/plat/new.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plat_show', methods: ['GET'])]
    public function show(Plat $plat): Response
    {
        return $this->render('admin/plat/show.html.twig', [
            'plat' => $plat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plat $plat, PlatRepository $platRepository, PictureService $pictureService): Response
    {
        //On récupère l'image
        $image = $plat->getImage()->getName();

        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //On défini le dossier de destination
            $folder = 'plats';

            //On appelle le service de suppression pour supprimer l'ancienne image
            $pictureService->delete($image, $folder, 300, 300);

            //On récupère la nouvelle image
             $image = $form->get('image')->getData();

            // //On défini le dossier de destination
            // $folder = 'plats';
            
             //On appelle le service d'ajout
             $fichier = $pictureService->add($image, $folder, 300, 300);
             
             $img = new Image;
             $img->setName($fichier);
 
             //On persiste notre image dans le plat
             $plat->setImage($img);

            $platRepository->save($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/plat/edit.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plat_delete', methods: ['POST'])]
    public function delete(Request $request ,Plat $plat, PlatRepository $platRepository, PictureService $pictureService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            
            //On récupère l'image
            $image = $plat->getImage()->getName();
            
            //On défini le dossier de destination
            $folder = 'plats';

            //On appelle le service de suppression
            $fichier = $pictureService->delete($image, $folder, 300, 300);
            

            // // Use unlink() function to delete a file
            // $image = $plat->getImage()->getName();
            // if (!unlink('../public/assets/uploads/images/plats/'.$image)) {
            // echo ("$image cannot be deleted due to an error");
            // }
            // else {
            // echo ("$image has been deleted");
            // }

            $platRepository->remove($plat, true);
        }

        return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
    }
}