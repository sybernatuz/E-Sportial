<?php

namespace App\Form\Front;

use App\Entity\Country;
use App\Entity\User;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationFormType extends AbstractType
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
                'required' => true
            ])
            ->add('country', EntityType::class, [
                'label' => 'Country',
                'class' => Country::class,
                'query_builder' => function (CountryRepository $countryRepository) {
                    return $countryRepository->createQueryBuilder('c')
                                             ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'choice_value' => 'id',
                'choice_attr' => function($entity, $key, $value) {
                    return ['data-icon' => $entity->getFlagPath()];
                },
                'attr' => [
                    'class' => 'icons'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => $this->translator->trans('Email'),
                'required' => true
            ])
            ->add('firstname', TextType::class, [
                'label' => $this->translator->trans('First name'),
                'required' => true
            ])
            ->add('lastname', TextType::class, [
                'label' => $this->translator->trans('Last name'),
                'required' => true
            ])
            ->add('age', IntegerType::class, [
                'label' => $this->translator->trans('Age'),
                'required' => true
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => $this->translator->trans('The password fields must match.'),
                'options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => $this->translator->trans('Please enter a password'),
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => $this->translator->trans('Your password should be at least {{ limit }} characters'),
                            'max' => 4096,
                        ]),
                    ]
                ],
                'mapped' => false,
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'first_name' => 'password',
                'second_name' => 'confirmation'
            ])
            ->add('signin', SubmitType::class, [
                'label' => $this->translator->trans('Sign in'),
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ])
            ->add('pro', CheckboxType::class, [
                'required' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
