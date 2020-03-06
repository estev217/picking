<?php

namespace App\Form\SavRetour;

use App\Entity\SavRetour\Commande;
use App\Entity\SavRetour\CommandeLigne;
use App\Repository\SavRetour\CommandeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeLigneType extends AbstractType
{
    private $commandeRepository;

    public function __construct(CommandeRepository $commandeRepository)
    {
        $this->commandeRepository = $commandeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commande' , EntityType::class, [
                "label" => false,
                "class" => Commande::class,
                'choice_label' => 'num_commande',
                'choices' => $this->commandeRepository->findAllByNum(),
            ])
            ->add('gencod',TextType::class, [
                "label" => false,
            ])
            ->add('qte', IntegerType::class, [
                "label" => false,
                'attr' => [
                    'min'  => 0,
                    'max'  => 10000,
                    'step' => 1
                ]
            ])
            ->add('encours', ChoiceType::class, [
                "label" => false,
                'placeholder' => false,
                "choices" => [
                    "Oui" => true,
                    "Non" => false,
                ]
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'choice',
                "label" => false,
                'placeholder' => [
                    'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',
                    'hour' => 'Heure', 'minute' => 'Minute',
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ])
            ->add('saveAndNew', SubmitType::class, [
            'attr' => ['class' => 'save and new'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandeLigne::class,
        ]);
    }
}
