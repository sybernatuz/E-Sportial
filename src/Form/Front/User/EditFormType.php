<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 04/02/2019
 * Time: 13:56
 */

namespace App\Form\Front\User;


use App\Entity\Country;
use App\Entity\User;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('username', TextType::class, [
                'label' => $this->translator->trans('Username'),
                'attr' => [
                    'placeholder' => $options['data']->getUsername()
                ],
                'required' => true
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
            ->add('email', EmailType::class, [
                'label' => $this->translator->trans('Email'),
                'attr' => [
                    'placeholder' => $options['data']->getEmail()
                ],
                'required' => true
            ])
            ->add('firstname', TextType::class, [
                'label' => $this->translator->trans('First name'),
                'attr' => [
                    'placeholder' => $options['data']->getFirstName()
                ],
                'required' => true
            ])
            ->add('lastname', TextType::class, [
                'label' => $this->translator->trans('Last name'),
                'attr' => [
                    'placeholder' => $options['data']->getLastName()
                ],
                'required' => true
            ])
            ->add('age', IntegerType::class, [
                'label' => $this->translator->trans('Age'),
                'attr' => [
                    'placeholder' => $options['data']->getAge()
                ],
                'required' => true
            ])
            ->add('pro', CheckboxType::class, [
                'value' => 0,
                'attr' => [
                    'value' => 0,
                    'placeholder' => true
                ],
                'required' => false
            ])
            ->add('modify', SubmitType::class, [
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
            'data_class' => User::class,
            'method' => 'post',
            'csrf_protection' => true,
            'allow_extra_fields' => true
        ]);
    }
}