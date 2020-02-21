<?php

namespace App\Form\SavRetour;

use App\Entity\SavRetour\Commande;
use App\Entity\SavRetour\CommandeLigne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeLigneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commande' ,EntityType::class, [
                "class" => Commande::class,
                'choice_label' => 'id',
                'required' => false,
                'label' => false,
                'placeholder' => 'Num Commande',
            ])
            ->add('gencod')
            ->add('qte')
            ->add('encours')
            ->add('date')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandeLigne::class,
        ]);
    }
}
