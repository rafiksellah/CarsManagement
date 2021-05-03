<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Choice;

class VehiculeType extends AbstractType
{   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('parcStationnementVille', ChoiceType::class, [
                'label' => 'Parc de stationnement (ville)',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Marseille' => 'Marseille',
                'Bastia' => 'Bastia',
                ],
            ])
            ->add('mark', null, ['label'=> 'Marque'])
            ->add('model')
            ->add('immatriculation', null, ['label'=> ' Modèle'])
            ->add('dateImmatriculation', DateType::class, [
                'years' => range(1990, date('Y'))
            ])
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
            ->add('dataAchat', DateType::class, [
                'label'=> 'Date d’achat',
                'years' => range(1990, date('Y'))
            ])
            ->add('kilometrageAchat')
            ->add('prix')
            ->add('options', ChoiceType::class, [
                'choices'  => [
                    'Clim'=>'Clim',
                    'GPS'=>'GPS',
                    'Limiteur de vitesse'=>'Limiteur de vitesse',
                    'Vitres électriques'=>'Vitres électriques',
                    'Régulateur de vitesse'=>'Régulateur de vitesse',
                    'Bluetooth'=>'Bluetooth',
                    'USB'=>'USB',
                    'AUX'=>'AUX',
                    ],
                'expanded'  => true,
                'multiple'  => true,
                'mapped'  => true,
            ])
            ->add('idVehiculeGetaround', null, ['label'=>'ID Getaround'])
            ->add('prixVente', null, ['label'=>'Prix de vente'])
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
