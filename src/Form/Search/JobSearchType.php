<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 13/02/2019
 * Time: 10:16
 */

namespace App\Form\Search;


use App\Entity\Search\JobSearch;
use App\Entity\Type;
use App\Enums\entity\EntityNameEnum;
use App\Repository\TypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class JobSearchType extends AbstractType
{

    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word', TextType::class, [
                'label' => $this->translator->trans('Search'),
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'label' => $this->translator->trans('Location'),
                'required' => false,
            ])
            ->add('type', EntityType::class, [
                'label' => 'Type',
                'class' => Type::class,
                'required' => true,
                'choice_label' => 'name',
                'choice_value' => 'name',
                'query_builder' => function (TypeRepository $typeRepository) {
                    return $typeRepository->createQueryBuilder('t')
                        ->where('t.entityName = \'' . EntityNameEnum::ENTITY_NAME_JOB . '\'')
                        ->orderBy('t.name', 'ASC');
                },
                'attr' => [
                    'class' => 'icons',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}