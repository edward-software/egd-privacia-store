<?php

namespace Paprec\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserEditType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('username', TextType::class, array(
                "required" => true
            ))
            ->add('companyName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('firstName', TextType::class)
            ->add('email', EmailType::class, array(
                "required" => true
            ))
            ->add('lang', ChoiceType::class, array(
                'choices' => $options['languages']
            ))
            ->add('phoneNumber')
            ->add('mobileNumber')
            ->add('jobTitle')
            ->add('enabled', ChoiceType::class, array(
                "choices" => array(
                    'No' => 0,
                    'Yes' => 1
                ),
                "expanded" => true
            ))
            ->add('roles', ChoiceType::class, array(
                "choices" => $options['roles'],
                "required" => true,
                "invalid_message" => 'Cannot be null',
                "expanded" => true,
                "multiple" => true,
                'constraints' => new NotBlank()
            ))//            ->add('postalCodes', TextType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Paprec\UserBundle\Entity\User',
            'validation_groups' => function (FormInterface $form) {
                return ['default'];
            },
            'roles' => null,
            'languages' => null
        ));
    }
}
