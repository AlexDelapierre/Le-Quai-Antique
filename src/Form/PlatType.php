<?php

namespace App\Form;

use App\Entity\Plat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', options:[
                'label' => 'Catégorie'
            ])
            ->add('title', options:[
                'label' => 'Nom'
            ])
            ->add('description')
            ->add('price', MoneyType::class, options:[
                'label' => 'Prix'
            ])
            ->add('image', filetype::class, [
                'label' => false,
                //La contrainte multiple permet de dire que c'est un tableau d'image
                // 'multiple' => true,
                //Symfony ne va pas vérifier si on a l'équivalent de filetype dans l'entité avec mapped
                'mapped' => false, 
                'required' => false,
            ])    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plat::class,
        ]);
    }
}