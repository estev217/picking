<?php

namespace App\Form\SavRetour;

use App\Entity\SavRetour\Commande;
use App\Entity\SavRetour\CommandeLigne;
use App\Entity\SavRetour\CommandeLigneSearch;
use App\Repository\SavRetour\CommandeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeLigneSearchType extends AbstractType
{
    private $commandeRepository;

    public function __construct(CommandeRepository $commandeRepository)
    {
        $this->commandeRepository = $commandeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gencod', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Recherche par gencod'
                ]
            ])
            ->add('commande', EntityType::class, [
                'class' => Commande::class,
                'choice_label' => 'num_commande',
                'required' => false,
                'label' => false,
                'choices' => $this->commandeRepository->findAllWithNumCmd(),
                'placeholder' => 'Toutes les commandes',
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