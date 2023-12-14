<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\TaskStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class Task1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('taskTitle', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Task title cannot be blank.']),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Task title must be at least {{ limit }} characters long.'
                    ]),
                ],
            ])
            ->add('creationDate', DateType::class, [
                'widget' => 'single_text',
                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Creation date cannot be blank.']),
                    new Assert\Type([
                        'type' => \DateTimeInterface::class,
                        'message' => 'Creation date should be a valid date format.'
                    ]),
                ],
            ])
            ->add('deadline', DateType::class, [
                'widget' => 'single_text',
                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Deadline cannot be blank.']),
                    new Assert\Type([
                        'type' => \DateTimeInterface::class,
                        'message' => 'Deadline should be a valid date format.'
                    ]),
                    new Assert\Callback([$this, 'validateDeadline']),
                ],
            ])
            ->add('status',EnumType::class, [
                'class' => TaskStatus::class,                
            ])
            
            ->add('assignedChef', EntityType::class, [
                'class' => 'App\Entity\User',
                'choice_label' => 'user_nom',
                'placeholder' => 'Select chef',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please select a chef.']),
                ]
            ])
            ->add('todos', CollectionType::class, [
                'entry_type' => TodoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }

    public function validateDeadline($value, ExecutionContextInterface $context): void
    {
        $form = $context->getRoot();
        $creationDate = $form['creationDate']->getData();

        if ($creationDate instanceof \DateTimeInterface && $value instanceof \DateTimeInterface) {
            if ($value <= $creationDate) {
                $context
                    ->buildViolation('Deadline must be greater than creation date.')
                    ->atPath('deadline')
                    ->addViolation();
            }
        }
    }
}
