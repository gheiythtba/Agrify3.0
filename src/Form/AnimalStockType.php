<?php

namespace App\Form;

use App\Entity\AnimalStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomAnimal')
            ->add('sexeAnimal')
            ->add('ageAnimal')
            ->add('poidsAnimal')
            ->add('health')
            ->add('dateEntreeStock')
            ->add('vente')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnimalStock::class,
        ]);
    }
}
