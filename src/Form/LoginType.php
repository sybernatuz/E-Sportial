<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($options['username_parameter'], TextType::class)
            ->add($options['password_parameter'], PasswordType::class)
            ->add('sign_in', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'username_parameter' => '_login_username',
            'password_parameter' => '_login_password',
            'csrf_field_name' => '_csrf_token',
            'csrf_token_id' => 'authenticate',
            'attr' => ['class' => 'col s10 m8 l8 xl8 offset-s1 offset-m2 offset-l2 offset-xl2']
        ])
            ->setAllowedTypes('username_parameter', 'string')
            ->setAllowedTypes('password_parameter', 'string')
        ;
    }
}
