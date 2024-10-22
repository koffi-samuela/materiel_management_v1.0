<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', null , ['label' => "Prénom"])
            ->add('lastname', null , ['label' => "Nom"])
            ->add('birthdate')
            ->add('is_active', CheckboxType::class, [
                'required' => false,
                'label' => 'Actif',
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'row_attr' => [
                    'class' => 'form-check form-switch'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
