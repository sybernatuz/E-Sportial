<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 02/07/2019
 * Time: 14:54
 */

namespace App\Form\Front\Event;


use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class NewFormType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => $this->translator->trans('Name'),
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => $this->translator->trans('Description')
            ])
            ->add('startDate', DateType::class, [
                'widget' => "single_text",
                'label' => $this->translator->trans('Start date'),
                'required' => true
            ])
            ->add('endDate', DateType::class, [
                'widget' => "single_text",
                'label' => $this->translator->trans('End date'),
                'required' => true
            ])
            ->add('location', TextType::class, [
                'label' => $this->translator->trans('Location'),
                'required' => true
            ])
            ->add('add', SubmitType::class, [
                'label' => $this->translator->trans('Add'),
                'attr' => [
                    'class' => 'waves-effect waves-light btn'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'method' => 'post',
            'csrf_protection' => true,
            'allow_extra_fields' => true,
            'attr' => [
                'novalidate' => "true"
            ]
        ]);
    }
}