<?php

namespace App\Form;

use App\DTOs\TaskFilterDTO;
use App\Entity\Task;
use App\Entity\TaskStatus;
use App\Transformers\TaskFilterTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAfter', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dueBefore', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('searchTitle', TextType::class, [
                'label' => 'Search Task',
                'required' => false,
            ])
            ->addModelTransformer(new TaskFilterTransformer());
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaskFilterDTO::class,
        ]);
    }
}
