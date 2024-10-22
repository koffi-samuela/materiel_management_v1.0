<?php

namespace App\Form;

use Symfony\component\form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\component\form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('query',TextType::class, [
                'attr' => [
                    'placeholder' => 'Rechercher...'
                ]
            ] );
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'method'=>'GET',
            'csrf_protection'=>false

        ]);
    }

}