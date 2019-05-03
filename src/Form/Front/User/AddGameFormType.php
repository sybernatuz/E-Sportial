<?php

namespace App\Form\Front\User;


use App\Entity\Game;
use App\Entity\GameAccount;
use App\Repository\GameRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class AddGameFormType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('game', EntityType::class, [
                'label' => 'Game',
                'class' => Game::class,
                'query_builder' => function (GameRepository $gameRepository) {
                    return $gameRepository->createQueryBuilder('g')->orderBy('g.name', 'ASC');
                },
                'choice_label' => 'name',
                'choice_attr' => function(Game $game, $key, $value) {
                    return ['data-icon' => $game->getPosterPath()];
                },
                'attr' => [
                    'class' => 'icons'
                ]
            ])
            ->add('pseudo', TextType::class, [
                'label' => $this->translator->trans('Pseudo')
            ])
            ->add('add', SubmitType::class, [
                'label' => $this->translator->trans('Add'),
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameAccount::class,
            'csrf_protection' => false,
            'attr' => ['id' => 'add-game-form']
        ]);
    }
}