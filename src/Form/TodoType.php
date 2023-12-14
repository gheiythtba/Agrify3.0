<?php

namespace App\Form;

use App\Entity\TaskStatus;
use App\Entity\Todo;
use App\Entity\TodoSeverity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('todoDescription', null , [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'No severity value for to is selected']),
                ]    
            ])
            ->add('severity',EnumType::class, [
                'class' => TodoSeverity::class,   
                'constraints' => [
                    new Assert\NotBlank(['message' => 'No severity value for to is selected']),
                ]             
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}
