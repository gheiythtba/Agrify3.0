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
            ->add('sexeAnimal',ChoiceType::class, [
                'choices' => [
                    'M' => 'M',
                    'F' => 'F',
                ],
            ])
            ->add('ageAnimal')
            ->add('poidsAnimal')
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
            'data_class' => AnimalStock::class,
        ]);
    }
}
