<?php

namespace App\Form\Back\Game;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameFormAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Name"
            ])
            ->add('posterFile', FileType::class, [
                "data_class" => null,
                "label" => "Image",
                "required" => false
            ])
            ->add('posterPath', TextType::class, [
                "attr" => [
                    "class" => "file-path validate"
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "attr" => [
                     "class" =>"materialize-textarea"
                ]
            ])
            ->add('apiUrl', TextType::class, [
                "label" => "Api url"
            ])
            ->add('enable', CheckboxType::class, [
                "label" => "Enable",
                "required" => false
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Save",
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
