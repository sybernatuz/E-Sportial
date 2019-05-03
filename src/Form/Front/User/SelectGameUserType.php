<?php

namespace App\Form\Front\User;

use App\Entity\Game;
use App\Entity\GameAccount;
use App\Repository\GameRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectGameUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('game', EntityType::class, [
                'label' => 'Game',
                'class' => Game::class,
                'query_builder' => function(GameRepository $gameRepository) use ($options) {
                    return $gameRepository->findUserGames($options['user'], true);
                },
                'choice_label' => 'name',
                'choice_attr' => function(Game $game, $key, $value) {
                    return ['data-icon' => $game->getPosterPath()];
                },
                'attr' => [
                    'class' => 'icons'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => null,
            'attr' => [
                "id" => "select-user-game"
            ]
        ]);
    }
}
