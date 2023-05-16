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
        $this->createPlat('Salade fermière', 'La Salade fermière est une délicieuse création qui allie les saveurs authentiques de la cuisine savoyarde avec des ingrédients frais et de qualité.', 13, '1200X700-4c2fe6287083648b1696b3eb8d2458b8.webp', 1, $manager);
        $this->createPlat('Clafoutis savoyard à la tome des Bauges', 'Un délicieux clafoutis savoyard à la tome des Bauges.', 13, '1200X700-61a392cb08a0564c7c5254e9de141684.webp', 1, $manager);
        $this->createPlat('Tartelettes savoyardes', 'De délicieuses tartelettes garnies de pommes de terre avec lardons et reblochon fondant.', 12, '1200X700-b9106b1afa231f4b29eb62e87bd7d24f.webp', 1, $manager);
        $this->createPlat('Tartiflette', 'La tartiflette savoyarde, un classique revisité avec élégance : une harmonie fondante de pommes de terre savoureuses, de reblochon crémeux et de lardons croustillants, sublimée par des notes délicates d\'oignons confits.', 18, '1200X700-908630abe48dbec306245dc3ef05594a.webp', 2, $manager);
        $this->createPlat('Fondue savoyarde', 'La fondue savoyarde, une célébration chaleureuse de fromages fondus à la perfection : une symphonie crémeuse de savoureux fromages de montagne, accompagnée de pains artisanaux croustillants pour une expérience gastronomique réconfortante et délicieuse.', 18, '1200X700-5484be838d79b7fc7745ca3ea9e9cbde.webp', 2, $manager);
        $this->createPlat('Potée de Diots de Savoie', 'La Potée de Diots de Savoie, une rencontre savoureuse entre saucisses de Savoie fumées et pomme de terre du terroir, mijotée lentement pour créer un mariage harmonieux de saveurs rustiques et délicates.', 17, '1200X700-1f531ace82248193a27ce5a1cf03edc1.webp', 2, $manager);
        $this->createPlat('Crème brulée', 'La crème brûlée, une sublime douceur exquise : une crème veloutée à la vanille de caractère, subtilement caramélisée à la perfection, offrant une expérience gustative raffinée et gourmande.', 11, '1200X700-409f07b2dceaf3618f250e8eabdf0695.webp', 3, $manager);
        $this->createPlat('Rissoles de Savoie', 'Les rissoles de Savoie, une délicate symphonie croustillante : de savoureuses poches de pâte feuilletée renfermant une farce généreuse aux saveurs traditionnelles des Alpes, offrant une explosion de goûts authentiques à chaque bouchée.', 8, '1200X700-7a3a2755e5cd0736315da1148aeee4ed.webp', 3, $manager);
        $this->createPlat('Profiteroles au chocolat', 'Les Profiteroles au chocolat, une tentation divinement chocolatée : de délicats choux garnis de crème légère à la vanille, nappés d\'un riche chocolat fondu et accompagnés d\'une touche de gourmandise pour émerveiller les papilles.', 10, '1200X700-330cbe765d04a5fe9aa2afba1c854341.webp', 3, $manager);
        
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