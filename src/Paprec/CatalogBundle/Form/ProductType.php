<?php

namespace Paprec\CatalogBundle\Form;

use Paprec\CatalogBundle\Entity\Argument;
use Paprec\CatalogBundle\Repository\ArgumentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('capacity')
            ->add('capacityUnit')
            ->add('folderNumber')
            ->add('dimensions', TextareaType::class)
            ->add('isEnabled', ChoiceType::class, array(
                "choices" => array(
                    'Non' => 0,
                    'Oui' => 1
                ),
                "expanded" => true,
            ))
            ->add('rentalUnitPrice')
            ->add('transportUnitPrice')
            ->add('treatmentUnitPrice')
            ->add('traceabilityUnitPrice')
            ->add('position')
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Paprec\CatalogBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'paprec_catalogbundle_product';
    }


}
