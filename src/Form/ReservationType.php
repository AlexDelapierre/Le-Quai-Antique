<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            // ->add('dateTime', DateTimeType::class, [
            //     'widget' => 'single_text',
            //     'label' => 'Date et heure'
            // ])

            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date'
            ])
            
            ->add('time', ChoiceType::class, [
                'choices' => [
                '12:00' => '12:00:00',
                '12:15' => '12:15',
                '12:30' => '12:30',
                ],
            ])

            // ->add('soir', ChoiceType::class, [
            //     'choices' => [
            //     '1' => '19:00',
            //     '2' => '19:15',
            //     '3' => '19:30',
            //     ],
            // ])
                
            
            ;  
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Reservation::class,
        ]);
    }
}