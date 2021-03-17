<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plateformeLocation',ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Getaround' => 'Getaround',
                'Ouicar' => 'Ouicar',
                ],
            ])
            ->add('parcStationnement', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Marseille' => 'Marseille',
                'Bastia' => 'Bastia',
                ],
            ])
            ->add('dateDebut')
            ->add('dateFin')
            ->add('remarque')
            ->add('prix')
            ->add('idLocationGetaround')
            ->add('idVehicule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
