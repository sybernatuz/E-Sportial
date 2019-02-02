<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ResetPasswordType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('resetPassword', SubmitType::class, [
                'label' => $this->translator->trans('Reset'),
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ]);
    }
}
