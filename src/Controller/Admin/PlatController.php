<?php

namespace App\Controller\Admin;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\HoraireRepository;
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
    public function index(PlatRepository $platRepository, HoraireRepository $horaireRepository): Response
    {
        return $this->render('admin/plat/index.html.twig', [
            'plats' => $platRepository->findAll(),
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_plat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlatRepository $platRepository,HoraireRepository $horaireRepository ,PictureService $pictureService): Response
    {
        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
     
            if($form->get('image')->getData() !== null) {
                
                //On récupère les images
                $image = $form->get('image')->getData();
                
                //On défini le dossier de destination
                $folder = 'plats';

                //On appelle le service d'ajout
                $fichier = $pictureService->add($image, $folder, 1200, 700);
                
                /*
                // Version avec l'entity Image :
                $img = new Image;
                $img->setName($fichier);
                */

                //On persiste notre image dans le plat
                $plat->setImage($fichier);
            }

            $platRepository->save($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/plat/new.html.twig', [
            'plat' => $plat,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_plat_show', methods: ['GET'])]
    public function show(Plat $plat, HoraireRepository $horaireRepository): Response
    {
        return $this->render('admin/plat/show.html.twig', [
            'plat' => $plat,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plat $plat, PlatRepository $platRepository,HoraireRepository $horaireRepository ,PictureService $pictureService): Response
    {
        /*
        // Version avec l'entity Image :
        On récupère le nom de l'image
        $image = $plat->getImage()->getName();
        */

        //On récupère le nom l'image
        $image = $plat->getImage();

        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //On défini le dossier de destination
            $folder = 'plats';

            if ($form->get('image')->getData() !== null) {

                if($image !== null) {
                    //On appelle le service de suppression pour supprimer l'ancienne image
                    $pictureService->delete($image, $folder, 1200, 700);
                }
    
                //On récupère la nouvelle image
                 $image = $form->get('image')->getData();
           
                 //On appelle le service d'ajout
                 $fichier = $pictureService->add($image, $folder, 1200, 700);
                 
                /* 
                // Version avec l'entity Image :
                $img = new Image;
                $img->setName($fichier);
                */
                
                //On persiste notre image dans le plat
                $plat->setImage($fichier);
            } else {
                //On récupère l'image d'origine
                $plat->setImage($image);
            };
 
            $platRepository->save($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/plat/edit.html.twig', [
            'plat' => $plat,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_plat_delete', methods: ['POST'])]
    public function delete(Request $request ,Plat $plat, PlatRepository $platRepository, PictureService $pictureService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            
            if($plat->getImage() !== null) {

                /*
                // Version avec l'entity Image :
                On récupère le nom l'image
                $image = $plat->getImage()->getName();
                */
    
                //On récupère le nom l'image
                $image = $plat->getImage();
                
                //On défini le dossier de destination
                $folder = 'plats';
    
                //On appelle le service de suppression
                $pictureService->delete($image, $folder, 1200, 700);
                
                /*
                // Use unlink() function to delete a file
                $image = $plat->getImage()->getName();
                if (!unlink('../public/assets/uploads/images/plats/'.$image)) {
                echo ("$image cannot be deleted due to an error");
                }
                else {
                echo ("$image has been deleted");
                }
                */
            } 

            $platRepository->remove($plat, true);
        }

        return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
    }
}