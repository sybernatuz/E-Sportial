<?php

namespace App\Form\Front\Roster;

use App\Entity\Game;
use App\Entity\Roster;
use App\Repository\GameRepository;
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
                'query_builder' => function (GameRepository $gameRepository) {
                    return $gameRepository->createQueryBuilder('g')->orderBy('g.name', 'ASC');
                },
                'choice_attr' => function(Game $game, $key, $value) {
                    return ['data-icon' => $game->getPosterPath()];
                },
                'choice_label' => 'name',
            ])
            ->add('create', SubmitType::class, [
                'label' => 'Create',
                'attr' => [
                    'style' => 'width: 100px',
                    'class' => 'waves-effect waves-light btn right'
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
