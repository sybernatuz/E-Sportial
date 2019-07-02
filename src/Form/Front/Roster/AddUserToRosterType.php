<?php

namespace App\Form\Front\Roster;

use App\Entity\Roster;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUserToRosterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name'
            ])
            ->add('game', EntityType::class, [
                'label' => 'Roster',
                'class' => Roster::class,
                'choice_label' => 'name',
            ])
            ->add('add', SubmitType::class, [
                'label' => 'Add',
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Roster::class,
            'attr' => ['id' => 'add-user-roster-form']
        ]);
    }
}
