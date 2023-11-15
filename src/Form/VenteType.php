<?php

namespace App\Form;

use App\Entity\Vente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('animalStock', CollectionType::class, [
            'entry_type' => AnimalStockType::class,
            'allow_add' => true,
            'by_reference' => false,
        ])
        ->add('planteStock', CollectionType::class, [
            'entry_type' => PlanteStockType::class,
            'allow_add' => true,
            'by_reference' => false,
        ])
        ->add('stockDivers', CollectionType::class, [
            'entry_type' => StockDiversType::class,
            'allow_add' => true,
            'by_reference' => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
