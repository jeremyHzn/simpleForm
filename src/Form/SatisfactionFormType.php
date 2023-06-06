<?php

namespace App\Form;

use App\Entity\Questions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SatisfactionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,
                options: [
                    'label' => 'Email',
                    'attr' => [
                        'placeholder' => 'Votre email',
                        'class' => 'email-parent'
                    ]
                ]
            )
            ->add('question1', ChoiceType::class, [
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10'
                ],
                'attr' => [
                    'class' => 'note-parent flex-space-beetween'
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Question 1',
            ])
            ->add('question2', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                    'Ne sais pas' => 'Ne sais pas',
                ],
                'attr' => [
                    'class' => 'choice-parent',
                    'item'  => 'Oui'
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Question 2',
            ])
            ->add('question3', options: [
                'label' => 'Question 3',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
        ]);
    }
}
