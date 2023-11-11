<?php

namespace App\Form;

use App\Entity\StockDivers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockDiversType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSD')
            ->add('quantiteSD')
            ->add('health')
            ->add('dateEntreeStock')
            ->add('vente')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockDivers::class,
        ]);
    }
}
