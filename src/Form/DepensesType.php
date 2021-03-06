<?php

namespace App\Form;

use App\Entity\Depenses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DepensesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('natureLibelle', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                'Société' => 'Société',
                'Assurance' => 'Assurance',
                'Transport' => 'Transport',
                ' Achat véhicule' => 'Achat véhicule',
                'Carte grise' => 'Carte grise',
                ' Contrôle technique' => ' Contrôle technique',
                'Abonnement Connect' => 'Abonnement Connect',
                'Nettoyage' => 'Nettoyage',
                'Entretien' => 'Entretien',
                'Réparation' => 'Réparation',
                'Parking' => 'Parking',
                'Carburant' => 'Carburant',   
                'Carsitting' => 'Carsitting',   
                ],
            ])
            ->add('prix')
            ->add('idVehicule', null, ['label'=> 'Véhicule'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Depenses::class,
        ]);
    }
}
