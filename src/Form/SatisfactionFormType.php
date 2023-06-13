<?php
declare(strict_types=1);

namespace App\Form;

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

final class SatisfactionFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(child:'email', type:EmailType::class,
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
            ->add('question1', type:ChoiceType::class, options:[
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
            ->add('question2', type:ChoiceType::class, options: [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                    'Ne sais pas' => null,
                ],
                'attr' => [
                    'class' => 'choice-parent',
                    'item'  => 'Oui'
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Question 2',
            ])
            ->add('question3', type:TextareaType::class, options: [
                'label' => 'Question 3',
                'constraints' => [
                    new MustBeAValidTextAreaRequirement()
                ],
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}
