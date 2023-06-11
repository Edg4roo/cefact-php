<?php

namespace App\Form;

use App\Entity\Student;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'placeholder' => 'Ingrese su nombre',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Teléfono',
                'attr' => [
                    'placeholder' => 'Ingrese su teléfono',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Ingrese su email',
                ],
            ])
            ->add('nia', TextType::class, [
                'label' => 'NIA',
                'attr' => [
                    'placeholder' => 'Ingrese su NIA',
                ],
            ])
            ->add('imageFile', VichImageType::class, [
                'empty_data' => '',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg'],
                        'mimeTypesMessage' => 'El fichero debe ser una imagen'
                    ])
                ]
            ]);

        // Eliminar el campo 'courses' del formulario
        $builder->remove('courses');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
