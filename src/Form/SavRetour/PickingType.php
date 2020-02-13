<?php

namespace App\Form\SavRetour;

use App\Entity\SavRetour\Picking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PickingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num_cmd')
            ->add('imei')
            ->add('gencod')
            ->add('date_heure')
            ->add('num_dossier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picking::class,
        ]);
    }
}
