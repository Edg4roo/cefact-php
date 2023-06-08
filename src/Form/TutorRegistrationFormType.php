<?php

namespace App\Form;

use App\Entity\StudyCenter;
use App\Entity\Tutor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TutorRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'required' => true,
                'mapped' => true

            ])
            ->add('phone', TextType::class, [
                'label' => 'Teléfono',
                'required' => true,
                'mapped' => true,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 10,
                        'minMessage' => 'El número de teléfono debe tener al menos {{ limit }} caracteres.',
                        'maxMessage' => 'El número de teléfono no puede tener más de {{ limit }} caracteres.',
                    ]),
                ]
            ])
            ->add('studyCenters', EntityType::class, [
                'class' => StudyCenter::class,
                'choice_label' => 'name',
                'mapped' => false
            ])
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tutor::class,
        ]);
    }
}
