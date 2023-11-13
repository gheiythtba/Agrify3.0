<?php

namespace App\Form;

use App\Entity\PlanteStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanteStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPlante')
            ->add('etatPlante' , ChoiceType::class, [
                'choices' => [
                    'Fruit' => 'Fruit',
                    'Légume' => 'Légume',
                    'Racines' => 'Racines',
                    'Grains' => 'Grains',
                    'Fleur' => 'Fleur',
                    'Arbre' => 'Arbre',
                    'Feuillage' => 'Feuillage',
                    'Extrait huileux' => 'Extrait huileux',
                ],
            ])
            ->add('health' , ChoiceType::class, [
                'choices' => [
                    'Sain' => 'Sain',
                    'Malsain' => 'Malsain',
                ],
            ])
            ->add('quantitePlante')
            ->add('dateEntreeStock')
            ->add('vente')
            ->add('save', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlanteStock::class,
        ]);
    }
}
