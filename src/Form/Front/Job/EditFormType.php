<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 05/03/2019
 * Time: 15:17
 */

namespace App\Form\Front\Job;


use App\Entity\Game;
use App\Entity\Job;
use App\Entity\Type;
use App\Entity\User;
use App\Repository\GameRepository;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class EditFormType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location', TextType::class, [
                'label' => $this->translator->trans('Location'),
                'attr' => [
                    'placeholder' => $options['data']->getLocation()
                ],
                'required' => true
            ])
            ->add('title', TextType::class, [
                'label' => $this->translator->trans('Title'),
                'attr' => [
                    'placeholder' => $options['data']->getTitle()
                ],
                'required' => true
            ])
            ->add('salary', NumberType::class, [
                'label' => $this->translator->trans('Salary'),
                'attr' => [
                    'placeholder' => $options['data']->getSalary()
                ],
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => $this->translator->trans('Description'),
                'attr' => [
                    'placeholder' => $options['data']->getDescription()
                ],
                'required' => true
            ])
            ->add('duration', NumberType::class, [
                'label' => $this->translator->trans('Duration'),
                'attr' => [
                    'placeholder' => $options['data']->getDuration()
                ],
                'required' => true
            ])
            ->add('type', EntityType::class, [
                'label' => 'Type',
                'class' => Type::class,
                'query_builder' => function (TypeRepository $typeRepository) {
                    return $typeRepository->createQueryBuilder('t')
                        ->where("t.entityName = :entityName")
                        ->setParameter('entityName', 'job');
                },
                'choice_label' => 'name',
                'choice_value' => 'id',
                'choice_attr' => function(Type $entity) {
                    return ['data-icon' => $entity->getName()];
                }
            ])
            ->add('game', EntityType::class, [
                'label' => 'Game',
                'class' => Game::class,
                'query_builder' => function (GameRepository $gameRepository) {
                    return $gameRepository->createQueryBuilder('g')->orderBy('g.name',  'ASC');
                },
                'choice_label' => 'name',
                'choice_value' => 'id',
                'choice_attr' => function(Game $entity) {
                    return ['data-icon' => $entity->getName()];
                }
            ])
            ->add('edit', SubmitType::class, [
                'label' => $this->translator->trans('Modify'),
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
            'method' => 'post',
            'csrf_protection' => true,
            'allow_extra_fields' => true
        ]);
    }
}