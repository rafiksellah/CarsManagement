<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Choice;

class VehiculeType extends AbstractType
{   
    const CHOIX1 = 'Clim';
    const CHOIX2 = 'GPS';
    const CHOIX3 = 'limiteur de vitesse';
    const CHOIX4 ='vitres électriques';
    const CHOIX5 ='régulateur de vitesse';
    const CHOIX6 ='Bluetooth';
    const CHOIX7 ='USB';
    const CHOIX8 ='AUX';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('parcStationnementVille', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Marseille' => 'Marseille',
                'Bastia' => 'Bastia',
                ],
            ])
            ->add('mark')
            ->add('model')
            ->add('immatriculation')
            ->add('dateImmatriculation')
            ->add('nombrePlace', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => ['1' => '1','2' => '2','3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'],
            ])
            ->add('nombrePorte', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => ['1' => '1','2' => '2','3' => '3', '4' => '4', '5' => '5'],
            ])
            ->add('phaseFinition')
            ->add('energie', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Essence' => 'Essence',
                'Diesel' => 'Diesel',
                'Electrique' => 'Electrique',
                'Hybride' => 'Hybride',
                'GPL' => 'GPL',
                ],
            ])
            ->add('couleur')
            ->add('dataAchat')
            ->add('kilometrageAchat')
            ->add('prix')
            ->add('options', ChoiceType::class, [
                'choices'  => [
                    'Clim' => self::CHOIX1,
                    'GPS' => self::CHOIX2,
                    'limiteur de vitesse' => self::CHOIX3,
                    'vitres électriques'=>self::CHOIX4,
                    'régulateur de vitesse'=>self::CHOIX5,
                    'Bluetooth'=>self::CHOIX6,
                    'USB'=>self::CHOIX7,
                    'AUX'=>self::CHOIX8,
                    ],
                'expanded'  => true,
                'multiple'  => true,
                'mapped'  => false,
            ])
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
