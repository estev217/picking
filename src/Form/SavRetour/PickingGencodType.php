<?php

namespace App\Form\SavRetour;

use App\Entity\SavRetour\Commande;
use App\Entity\SavRetour\CommandeLigne;
use App\Repository\SavRetour\CommandeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PickingGencodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gen', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => false,
            ])
            ->add('picking', IntegerType::class, [
                'label' => false,
            ])
            ->add('saveAndNew', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandeLigne::class,
        ]);
    }
}
