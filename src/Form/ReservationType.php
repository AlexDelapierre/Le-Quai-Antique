<?php

namespace App\Form;

use App\Entity\Midi;
use App\Entity\Reservation;
use App\Entity\Soir;
use App\Repository\MidiRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', options:[
                'label' => 'Nom',
                // 'constraints' => new NotBlank(['message' => 'Entrez un nom.'])
            ])
            ->add('firstname', options:[
                'label' => 'Prénom'
            ])
            ->add('phoneNumber', options:[
                'label' => 'Numéro de téléphone',
                // 'constraints' => [
                //     new NotBlank(['message' => 'Entrez un nom.']),
                //     new Length(['min' => 10, 'minMessage' => '> {{ limit }}'])    
                // ] 
            ])
            ->add('nbCouverts', NumberType::class, [
                'label' => 'Nombre de personnes',
                'html5' => true,
                // 'attr' => ['id' => 'nom-du-champ']
            ])  
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date'
            ]) 
            ->add('service', ChoiceType::class, [
                'choices' => [
                'midi' => 'midi',
                'soir' => 'soir',
                ],
                'label' => 'Midi ou soir ?',
            ]) 
            ->add('comments', options:[
                'label' => 'Allergies'
            ])  
            ->add('midi', EntityType::class, [
                'class' => Midi::class,
                // 'placeholder' => 'Midi ou soir ?',
                'label' => 'Choisissez une heure',
                // 'query_builder'=> function(MidiRepository $midiRepository) {
                //     return $midiRepository->createQueryBuilder('m')->orderBy('m.time', 'ASC');
                // }
            ])    
             ->add('soir', EntityType::class, [
                'class' => Soir::class,
                'label' => 'Soir',
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}