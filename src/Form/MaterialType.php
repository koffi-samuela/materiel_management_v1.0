<?php

namespace App\Form;

use App\Entity\Material;
use App\Entity\MaterialKind;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>"Nom",
                'attr' => ['class' => 'textInput']

            ])
            ->add('serial_number',TextType::class,[
                'label'=>"N° de série",
                'attr' => ['class' => 'textInput']

            ])
            ->add('tag_number',TextType::class,[
                'label'=>"N° d'étiquette",
                'attr' => ['class' => 'textInput']
            ])
            ->add('comment',TextareaType::class,[
                'label'=>"Commentaire",
                'attr' => ['class' => 'textInput']
            ])
            // ->add('location')
            ->add('is_available',CheckboxType::class,[
                'label'=>"Est-il disponible ?",
                'required'=>false,
            ])
            ->add('materialKind', EntityType::class, [
                'class' => MaterialKind::class,
                'choice_label' => 'id',
                'label'=>"Type du matériel"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
            'submit_button_label' => 'Créer'
        ]);
    }
}
