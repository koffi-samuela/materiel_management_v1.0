<?php

namespace App\Form;

use App\Entity\Borrowing;
use App\Entity\Employee;
use App\Entity\Material;
use App\Entity\Student;
use App\Entity\TrainingProgram;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class BorrowingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('borrow_date',DateType::class,[
               'label'=>"Date d'emprunt" 
            ])
            ->add('expected_return_date',DateType::class,[
               'label'=>"Date de retour estimée" 
            ])
            ->add('actual_return_date',DateType::class,[
                'label'=>"Date de retour" ,
                'required' => false, 
                
            ])
            ->add('comment', TextareaType::class, [
                'label' => "Commentaire",
                'required' => false, 
            ])
            

            ->add('material', EntityType::class, [
                'class' => Material::class,
'choice_label' => 'name',
            ])
            ->add('trainingProgram', EntityType::class, [
                'class' => TrainingProgram::class,
'choice_label' => 'name',
            ])
            
            ->add('student', EntityType::class, [
                'class' => Student::class,
'choice_label' => 'firstname' ,
'required' => false, 
            ])
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
'choice_label' => 'firstname',
'required' => false, 
            ])
//             ->add('employee_borrow', EntityType::class, [
//                 'class' => Employee::class,
// 'choice_label' => 'id',
//             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Borrowing::class,
        ]);
    }
}
