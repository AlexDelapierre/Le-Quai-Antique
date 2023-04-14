<?php

namespace App\DataFixtures;

use App\Entity\Plat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlatFixtures extends Fixture
{
    private $counter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->createPlat('Salade du chef', 'Le poulet, les oeufs, le fromage bleu et l’avocat mûr font de cette succulente salade un plat très nourrissant.', 14, '1200X700-1de666b2bbde81e0d59fc67d1a149e6c.webp', 1, $manager);
        $this->createPlat('Spaghetti', 'Spaghetti Napoli Pasta al Pomodoro !', 15, '1200X700-011d64a779dc23db7e00f33f035c713d.webp', 2, $manager);
        $this->createPlat('Tiramisu', 'Un super tiramisu', 6, '1200X700-49817dba28263d1317fbe955905a91b7.webp', 3, $manager);

        $manager->flush();
    }

    public function createPlat(string $title, string $description, float $price, string $image, int $counterCategory, ObjectManager $manager)
    {
        $plat = new Plat();
        $plat->setTitle($title);
        $plat->setDescription($description);
        $plat->setPrice($price);
        $plat->setImage($image);
        $manager->persist($plat);

        //On va chercher une référence de CatégorieFixtures 
        $category = $this->getReference('cat-'.$counterCategory);
        $plat->setCategory($category);

        #Référence : mis en mémoire sous un nom d'un élément pour GalerieFixtures
        $this->setReference('plat-'.$this->counter, $plat);
        $this->counter++;
        
        return $plat;
    }
}