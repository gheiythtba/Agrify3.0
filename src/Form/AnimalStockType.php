<?php

namespace App\Form;

use App\Entity\AnimalStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


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
            ->add('image')
            ->add('prix', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnimalStock::class,
        ]);
    }
}
