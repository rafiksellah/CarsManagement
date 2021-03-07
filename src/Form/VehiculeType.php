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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modeFinancement', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'ouicar' => 'Ouicar',
                'autre' => 'Autre',
                ],
            ])     
            ->add('parcStationnementVille', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Marseille' => 'Marseille',
                'Bastia' => 'Bastia',
                ],
            ])
            ->add('model', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Peaugeat' => 'Peaugeat',
                'Renault' => 'Renault',
                'Citroene' => 'Citroene',
                ],
            ])
            ->add('immatriculation')
            ->add('dateImmatriculation')
            ->add('nombrePlace')
            ->add('nombrePorte')
            ->add('phaseFinition', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Zen' => 'Zen',
                'Autre' => 'Autre',
                ],
            ])
            ->add('energie', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Diesel' => 'Diesel',
                'Essence' => 'Essence',
                'Hybride' => 'Hybride',
                ],
            ])
            ->add('couleur', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Blanche' => 'Blanche',
                'Noir' => 'Noir',
                'Grise' => 'Grise',
                ],
            ])
            ->add('dateDebutContrat')
            ->add('apport')
            ->add('dureeFinancement')
            ->add('loyerMensuel')
            ->add('dataAchat')
            ->add('kilometrageAchat')
            ->add('prix')
            ->add('options', ChoiceType::class, [
                'choices'  => [
                    'Clim' => self::CHOIX1,
                    'GPS' => self::CHOIX2,
                    'limiteur de vitesse' => self::CHOIX3,
                    'vitres électriques'=>self::CHOIX4,
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
