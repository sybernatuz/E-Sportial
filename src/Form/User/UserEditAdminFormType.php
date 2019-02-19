<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 19/02/2019
 * Time: 10:11
 */

namespace App\Form\User;


use App\Entity\User;
use App\Enums\role\RolesEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserEditAdminFormType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = RolesEnum::getValues();
        $builder
            ->add('username', TextType::class, [
                'label' => $this->translator->trans('Username'),
                'required' => true,
            ])
            ->add('email', TextType::class, [
                'label' => $this->translator->trans('Email'),
                'required' => true,
            ])
            ->add('lastname', TextType::class, [
                'label' => $this->translator->trans('Last name'),
                'required' => true,
            ])
            ->add('firstname', TextType::class, [
                'label' => $this->translator->trans('First name'),
                'required' => true,
            ])
            ->add('age', IntegerType::class, [
                'label' => $this->translator->trans('Age'),
                'required' => true,
            ])
            ->add('edit', SubmitType::class, [
                'label' => $this->translator->trans('Edit'),
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => $this->getRoles(),
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'method' => 'post',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

    private function getRoles() : array
    {
        $roles = RolesEnum::getValues();
        $rolesKeyValue = [];
        foreach ($roles as $role) {
            if ($role != '')
                $rolesKeyValue[$role] = $role;
        }
        return $rolesKeyValue;
    }
}