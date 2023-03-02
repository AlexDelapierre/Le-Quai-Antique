<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private $counter = 1;
    
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Entrée', null, $manager);
        $parent = $this->createCategory('Plats', null, $manager);
        $parent = $this->createCategory('Desserts', null, $manager);
        
       
        $manager->flush();
    }

    public function createCategory(string $name, Category $parent = null, ObjectManager $manager)
    {
        $category = new Category();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        #Référence : mis en mémoire sous un nom d'un élément
        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++; 
        
        return $category;
    }
}