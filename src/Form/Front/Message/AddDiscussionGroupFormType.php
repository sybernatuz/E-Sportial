<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 21/06/2019
 * Time: 14:35
 */

namespace App\Form\Front\Message;


use App\Entity\DiscussionGroup;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class AddDiscussionGroupFormType extends AbstractType
{
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => $this->translator->trans('Group name'),
            ])
            ->add('users', CollectionType::class, [
                'label' => $this->translator->trans('Username'),
                'entry_type' => User::class,
            ])
            ->add('messages', CollectionType::class, [
                'entry_type'   => AddMessageFormType::class,
                'allow_add' => true
            ])
            ->add('add', SubmitType::class, [
                'label' => $this->translator->trans('Send'),
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ]);
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DiscussionGroup::class,
            'csrf_protection' => false,
            'attr' => ['id' => 'add-discussion-group-form']
        ]);
    }
}