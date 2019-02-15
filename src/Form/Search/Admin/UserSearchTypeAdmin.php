<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 15/02/2019
 * Time: 14:36
 */

namespace App\Form\Search\Admin;


use App\Entity\Search\Admin\UserSearchAdmin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserSearchTypeAdmin extends AbstractType
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
                'required' => false,
            ])
            ->add('email', TextType::class, [
                'label' => $this->translator->trans('Email'),
                'required' => false,
            ])
            ->add('firstName', TextType::class, [
                'label' => $this->translator->trans('First name'),
                'required' => false,
            ])
            ->add('lastName', TextType::class, [
                'label' => $this->translator->trans('Last name'),
                'required' => false,
            ])
            ->add('age', IntegerType::class, [
                'label' => $this->translator->trans('Age'),
                'required' => false,
            ])
            ->add('online', ChoiceType::class, [
                'placeholder' => false,
                'choices' => [
                    $this->translator->trans('All') => null,
                    $this->translator->trans('Online') => 1,
                    $this->translator->trans('Offline') => 0,
                ],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSearchAdmin::class,
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