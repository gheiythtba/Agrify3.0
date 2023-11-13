<?php

namespace App\Form;

use App\Entity\StockDivers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StockDiversType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSD',  ChoiceType::class, [
                'choices' => [
                    'Miel' => 'Miel',
                    'Lait' => 'Lait',
                    'Oeufs' => 'Oeufs',
                    'Cire' => 'Cire',
                    'Laine' => 'Laine',
                    'Peau' => 'Peau',
                    'Fumier' => 'Fumier',
                    'Déchet végétal' => 'Déchet végétal',
                ],
            ])
            ->add('quantiteSD')
            ->add('health' , ChoiceType::class, [
                'choices' => [
                    'Sain' => 'Sain',
                    'Malsain' => 'Malsain',
                ],
            ])
            ->add('dateEntreeStock')
            ->add('vente')
            ->add('save', SubmitType::class) 

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockDivers::class,
        ]);
    }
}
