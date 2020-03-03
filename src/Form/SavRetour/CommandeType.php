<?php

namespace App\Form\SavRetour;

use App\Entity\SavRetour\Commande;
use App\Entity\SavRetour\CommandeLigne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numCommande', NumberType::class, [
                "label" => false,
            ])
            ->add('demandeur', TextType::class, [
                "label" => false,
            ])
            ->add('magasin_cedant', TextType::class, [
                "label" => false,
            ])
            ->add('destination', TextType::class, [
                "label" => false,
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'choice',
                "label" => false,
                'placeholder' => [
                    'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',
                    'hour' => 'Heure', 'minute' => 'Minute',
                ],
            ])
            ->add('solde', ChoiceType::class, [
                "label" => false,
                'placeholder' => false,
                "choices" => [
                    "Oui" => true,
                    "Non" => false,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
