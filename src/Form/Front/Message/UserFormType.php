<?php


namespace App\Form\Front\Message;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserFormType extends AbstractType
{
    private $translator;
    private $usernameToUserTransformer;

    public function __construct(TranslatorInterface $translator, UsernameToUserTransformer $usernameToUserTransformer)
    {
        $this->usernameToUserTransformer = $usernameToUserTransformer;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => $this->translator->trans('Username'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
            'attr' => ['id' => 'add-message-form']
        ]);
    }
}