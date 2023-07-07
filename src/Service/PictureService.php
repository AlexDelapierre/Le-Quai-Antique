<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureService
{
  private $params;

  public function __construct(ParameterBagInterface $params)
  {
    //Grâce au ParameterBagInterface, la propriété $params contient les informations qui se trouvent... 
    //dans les parametres du fichier service.yaml dans le dossier config.
    $this->params = $params;
  }

  /*
  //Méthode pour recadrer l'image en carré centré
  public function add(UploadedFile $picture, ?string $folder = '', ?int $width = 250, ?int $height = 250)
   {
    // On donne un nouveau nom à l'image
    $fichier = md5(uniqid(rand(), true)) . '.webp';

    // On récupère les infos de l'image
    $picture_infos = getimagesize($picture);

    if($picture_infos === false){
      throw new Exception('Format d\'image incorrect');
    }

    //On vérifie le format de l'image
    switch($picture_infos['mime']){
      case 'image/png':
        $picture_source = imagecreatefrompng($picture);
        break;
      case 'image/jpeg':
        $picture_source = imagecreatefromjpeg($picture);
        break;
      case 'image/webp':
        $picture_source = imagecreatefromwebp($picture);
        break;
      default:   
        throw new Exception('Format d\'image incorrect');
    }

    // On recadre l'image
    // On récupère les dimensions
    $imageWidth = $picture_infos[0];
    $imageHeight = $picture_infos[1];

    // On vérifie l'orientation de l'image
    switch($imageWidth <=> $imageHeight){
      case -1: //Si largeur est inférieur à la hauteur, c'est un portrait
        $squareSize = $imageWidth;
        $src_x = 0;
        $src_y = ($imageHeight - $squareSize) / 2;
        break;
      case 0: //Si largeur est égale à la hauteur, c'est un carré
        $squareSize = $imageWidth;
        $src_x = 0;
        $src_y = 0;
        break;
      case 1: //Si largeur est supérieur à la hauteur, c'est un paysage
        $squareSize = $imageHeight;
        $src_x = ($imageWidth - $squareSize) / 2;
        $src_y = 0;
        break;
    }

    // On crée une nouvelle image vierge
    $resized_picture = imagecreatetruecolor($width, $height);

    imagecopyresampled($resized_picture, $picture_source, 0, 0, $src_x, $src_y, $width, $height, 
    $squareSize, $squareSize);

    $path = $this->params->get('images_directory') . $folder;
    
    //On crée le dossier de destination s'il n'existe pas
    if(!file_exists($path)){
      mkdir($path, 0755, true);
    }

    //On stocke l'image recadrée 
    imagewebp($resized_picture, $path .'/'. $width . 'X' .$height . '-' . $fichier);
  
    //Je déplace le fichier de taille d'origine dans le path (le '/' sert à des problème éventuels dans windows).
    // $picture->move($path . '/', $fichier);

    //On récupère le nom de l'image redimensionnée
    $webp_filename = $width . 'X' .$height . '-' . $fichier;

    //On retourne le nom de l'image redimensionnée
    return $webp_filename;

    //On retourne le nom d'origine de l'image (ancienne version)
    // return $fichier;
  }
  */

  //Méthode pour recadrer l'image en rectangle centré
  public function add(UploadedFile $picture, ?string $folder = '', ?int $width = 250, ?int $height = 250)
  {
    // On donne un nouveau nom à l'image
    $fichier = md5(uniqid(rand(), true)) . '.webp';

    // On récupère les infos de l'image
    $picture_infos = getimagesize($picture);

    if ($picture_infos === false) {
        throw new Exception('Format d\'image incorrect');
    }

    //On vérifie le format de l'image
    switch ($picture_infos['mime']) {
        case 'image/png':
            $picture_source = imagecreatefrompng($picture);
            break;
        case 'image/jpeg':
            $picture_source = imagecreatefromjpeg($picture);
            break;
        case 'image/webp':
            $picture_source = imagecreatefromwebp($picture);
            break;
        default:
            throw new Exception('Format d\'image incorrect');
    }

    // On recadre l'image
    // On récupère les dimensions
    $imageWidth = $picture_infos[0];
    $imageHeight = $picture_infos[1];

    // On calcule les dimensions du rectangle
    $ratio = $imageWidth / $imageHeight;
    $targetRatio = $width / $height;
    if ($ratio > $targetRatio) { // l'image est plus large que haute, on utilise la hauteur comme référence
        $h = $imageHeight;
        $w = round($h * $targetRatio);
    } else { // l'image est plus haute que large, on utilise la largeur comme référence
        $w = $imageWidth;
        $h = round($w / $targetRatio);
    }

    // On calcule la position de départ pour le recadrage centré
    $src_x = ($imageWidth - $w) / 2;
    $src_y = ($imageHeight - $h) / 2;

    // On crée une nouvelle image vierge
    $resized_picture = imagecreatetruecolor($width, $height);

    imagecopyresampled(
        $resized_picture,
        $picture_source,
        0,
        0,
        $src_x,
        $src_y,
        $width,
        $height,
        $w,
        $h
    );

    $path = $this->params->get('images_directory') . $folder;

    //On crée le dossier de destination s'il n'existe pas
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
    }

    //On stocke l'image recadrée
    imagewebp($resized_picture, $path . '/' . $width . 'X' . $height . '-' . $fichier);

    /*
    //Je déplace le fichier de taille d'origine dans le path (le '/' sert à des problème éventuels dans windows).
    $picture->move($path . '/', $fichier);
    */

    //On récupère le nom de l'image redimensionnée
    $webp_filename = $width . 'X' . $height . '-' . $fichier;

    //On retourne le nom de l'image redimensionnée
    return $webp_filename;

    /*
    //On retourne le nom d'origine de l'image (ancienne version)
    return $fichier;
    */
  }


  public function delete(string $fichier, ?string $folder = '', ?int $width = 250, ?int $height = 250)
  {
    if($fichier !== 'default.webp'){
      $success = false;
      $path = $this->params->get('images_directory') . $folder;

      // $mini = $path . '/mini/' . $width . 'X' .$height . '-' . $fichier;
      $filePath = $path . '/' . $fichier;

      if(file_exists($filePath)){
        unlink($filePath);
        $success = true;
      }

      /*
      $original = $path . '/' . $fichier;
      
      if(file_exists($original)){
        unlink($original);
        $success = true;
      }
      */
      
      return $success;
    }
    return false;
  }
}