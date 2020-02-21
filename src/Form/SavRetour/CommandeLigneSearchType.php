<?php

namespace App\Form\SavRetour;

use App\Entity\SavRetour\Commande;
use App\Entity\SavRetour\CommandeLigne;
use App\Entity\SavRetour\CommandeLigneSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeLigneSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gencod', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Gencod',
                ]
            ])
            ->add('encours', ChoiceType::class, [
                'label' => 'Encours',
                'required' => false,
                'choices' => [
                    'encours' => true,
                    'pas d\'encours' => false,
                ]
            ])
            ->add('commande', EntityType::class, [
                'class' => Commande::class,
                'choice_label' => 'id',
                'required' => false,
                'label' => false,
                'placeholder' => 'Num Commande',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandeLigneSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}