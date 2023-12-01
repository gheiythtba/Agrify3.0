<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'label' => 'Nom de l\'animal',
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Mâle' => 'male',
                    'Femelle' => 'female',
                ],
                'required' => false,
                'label' => 'Sexe de l\'animal',
            ])
            ->add('ageMin', IntegerType::class, [
                'required' => false,
                'label' => 'Âge minimum',
            ])
            ->add('ageMax', IntegerType::class, [
                'required' => false,
                'label' => 'Âge maximum',
            ])
            ->add('poidsMin', IntegerType::class, [
                'required' => false,
                'label' => 'Poids minimum',
            ])
            ->add('poidsMax', IntegerType::class, [
                'required' => false,
                'label' => 'Poids maximum',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
