<?php

namespace App\Form;

use App\Entity\PlanteStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPlante')
            ->add('etatPlante')
            ->add('health')
            ->add('quantitePlante')
            ->add('dateEntreeStock')
            ->add('prix')
            ->add('image')
            ->add('vente')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlanteStock::class,
        ]);
    }
}
