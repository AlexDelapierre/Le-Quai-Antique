<?php

namespace App\Form;

use App\Entity\Horaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('monday', TextareaType::class, [
                'label' => 'Lundi',
                'trim' => true
            ])
            ->add('tuesday', options:[
                'label' => 'Mardi'
            ])
            ->add('wednesday', options:[
                'label' => 'Mercredi'
            ])
            ->add('thursday', options:[
                'label' => 'Jeudi'
            ])
            ->add('friday', options:[
                'label' => 'Vendredi'
            ])
            ->add('saturday', options:[
                'label' => 'Samedi'
            ])
            ->add('sunday', options:[
                'label' => 'Dimanche'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horaire::class,
        ]);
    }
}