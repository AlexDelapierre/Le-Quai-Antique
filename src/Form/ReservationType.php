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
            ->add('service', ChoiceType::class, [
                'choices' => [
                'midi' => 'midi',
                'soir' => 'soir',
                ],
            ])
            // ->add('dateTime', DateTimeType::class, [
            //     'widget' => 'single_text',
            //     'label' => 'Date et heure'
            // ])

            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date'
            ])         
            ->add('midi', ChoiceType::class, [
                'choices' => [
                '12:00' => '12:00:00',
                '12:15' => '12:15:00',
                '12:30' => '12:30:00',
                ],
            ])
            ->add('soir', ChoiceType::class, [
                'choices' => [
                '19:00' => '19:00:00',
                '19:15' => '19:15:00',
                '19:30' => '19:30:00',
                ],
            ])
            ->add('comments', options:[
                'label' => 'Commentaires'
            ]);  
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Reservation::class,
        ]);
    }
}