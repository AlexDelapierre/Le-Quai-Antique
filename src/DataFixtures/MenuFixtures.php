<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    private $counter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->createMenu('Menu du marché', $manager);

        $manager->flush();
    }

    public function createMenu(string $title ,ObjectManager $manager)
    {
        $menu = new Menu();
        $menu->setTitle($title);
        $manager->persist($menu); 

        #Référence : mis en mémoire sous un nom d'un élément
        $this->addReference('menu-'.$this->counter, $menu);
        $this->counter++; 
    }
}