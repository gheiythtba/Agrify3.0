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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\AnimalStockRepository;








class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('category' , ChoiceType::class, [
            'label' => 'Cathégorie',
            'choices' => [
                'StockAniaml' => 'SaStockAniamlin',
                'StockPlante' => 'StockPlante',
                'StockDivers' => 'StockDivers',
            ],
        ])

        ->add('nom', EntityType::class, [
            'label' => 'Nom',
            'class' => AnimalStock::class, 
            'choice_label' => 'nomAnimal', 
            'query_builder' => function (AnimalStockRepository $repository) {
                return $repository->createQueryBuilder('a')
                    ->orderBy('a.nomAnimal', 'ASC'); 
            },
            'multiple' => false, 
            'expanded' => false, 
        ])

        
        ->add('quantiteV', TextType::class, [
            'label' => 'Quantité',
        ])
       
        ->add('prixTotal')
        ->add('dateVente')
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
