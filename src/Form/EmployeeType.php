<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType; // Importez cette classe
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmployeeType extends AbstractType
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null , ['label' => "Nom d'ulisateur"])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Employé' => 'ROLE_EMPLOYEE',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Enseignant' => 'ROLE_TEACHER',
                    'Directrice' => 'ROLE_HEADMASTER'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles' 
            ])
            ->add('password', PasswordType::class) // Utilisez PasswordType pour le champ de mot de passe
            ->add('lastname', null , ['label' => "Nom"])
            ->add('firstname', null , ['label' => "Prénom"])
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }

    // Si besoin, d'autres méthodes peuvent être implémentées ici
}