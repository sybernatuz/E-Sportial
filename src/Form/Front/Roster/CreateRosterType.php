<?php

namespace App\Form\Front\Roster;

use App\Entity\Game;
use App\Entity\Roster;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateRosterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name'
            ])
            ->add('game', EntityType::class, [
                'label' => 'Game',
                'class' => Game::class,
                'choice_label' => 'name',
            ])
            ->add('create', SubmitType::class, [
                'label' => 'Create',
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Roster::class,
            'attr' => ['id' => 'create-roster-form']
        ]);
    }
}
