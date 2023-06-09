<?php

namespace App\Form;

use App\Entity\Questions;
use App\Validator\Constraints\MustBeAValidBoolChoiceRequirement;
use App\Validator\Constraints\MustBeAValidEmailRequirements;
use App\Validator\Constraints\MustBeAValidNoteRequirement;
use App\Validator\Constraints\MustBeAValidTextAreaRequirement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class SatisfactionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,
                options: [
                    'label' => 'Email',
                    "required" => false,
                    'constraints' => [
                        new MustBeAValidEmailRequirements()
                    ],
                    'attr' => [
                        'placeholder' => 'Votre email',
                        'class' => 'email-parent'
                    ]
                ]
            )
            ->add('question1', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10
                ],
                'attr' => [
                    'class' => 'note-parent flex-space-beetween'
                ],
                "constraints" => [
                    new MustBeAValidNoteRequirement(),
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
                'constraints' => [
                    new MustBeAValidBoolChoiceRequirement()
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Question 2',
            ])
            ->add('question3',TextareaType::class, options: [
                'label' => 'Question 3',
                'constraints' => [
                    new MustBeAValidTextAreaRequirement()
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}
