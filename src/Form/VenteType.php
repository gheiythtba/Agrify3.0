<?php

namespace App\Form;

use App\Entity\Vente;
use App\Entity\AnimalStock;
use App\Entity\PlanteStock;
use App\Entity\StockDivers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;





class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('animalStock', CollectionType::class, [
            'entry_type' => AnimalStockType::class,
            'allow_add' => true,
            'by_reference' => false,
            'label' => 'Animals',
        ])
        ->add('planteStock', CollectionType::class, [
            'entry_type' => PlanteStockType::class,
            'allow_add' => true,
            'by_reference' => false,
            'label' => 'Plants',
        ])
        ->add('stockDivers', CollectionType::class, [
            'entry_type' => StockDiversType::class,
            'allow_add' => true,
            'by_reference' => false,
            'label' => 'Other Stocks',
        ])
        ->add('quantiteV', TextType::class, [
            'label' => 'Quantité',
        ])
       
        ->add('prixTotal', MoneyType::class, [
            'label' => 'Total Price',
            'mapped' => false, // This field is not mapped to any entity property
            'attr' => [
                'readonly' => true,
            ],
        ])
        ->add('dateVente', DateType::class, [
            'label' => 'Sale Date',
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'html5' => false,
        ])
        // Add other fields as needed
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
