<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', options:[
                'label' => 'Nom'
            ])
            ->add('firstname', options:[
                'label' => 'Prénom'
            ])
            ->add('phoneNumber', options:[
                'label' => 'Numéro de téléphone'
            ])
            ->add('nbCouverts', options:[
                'label' => 'Nombre de couverts'
            ])
            ->add('dateTime', DateTimeType::class, [
                'widget' => 'single_text'
            ]);  
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}