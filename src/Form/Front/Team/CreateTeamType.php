<?php

namespace App\Form\Front\Team;

use App\Entity\Country;
use App\Entity\Organization;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateTeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'materialize-textarea',
                ]
            ])
            ->add('logoFile', FileType::class, [
                "data_class" => null,
                "label" => "Logo",
                "required" => false,
            ])
            ->add('logoPath', TextType::class, [
                'label' => 'Logo',
                "attr" => [
                    "class" => "file-path validate"
                ]
            ])
            ->add('country', EntityType::class, [
                'label' => 'Country',
                'class' => Country::class,
                'query_builder' => function (CountryRepository $countryRepository) {
                    return $countryRepository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'choice_value' => 'id',
                'choice_attr' => function(Country $entity, $key, $value) {
                    return ['data-icon' => $entity->getFlagPath()];
                },
                'attr' => [
                    'class' => 'icons'
                ]
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
            'data_class' => Organization::class,
        ]);
    }
}
