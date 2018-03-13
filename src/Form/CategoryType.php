<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{
    TextType, TextareaType
};

/**
 * Class CategoryType
 *
 * @package App\Form
 */
class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'required'   => true,
                    'label'      => 'Name*',
                    'label_attr' => [
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'attr'       => [
                        'class'       => 'form-control col-md-7 col-xs-12',
                        'placeholder' => 'Name'
                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'required'   => true,
                    'label'      => 'Description*',
                    'label_attr' => [
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'attr'       => [
                        'class'       => 'form-control col-md-7 col-xs-12',
                        'placeholder' => 'Description'
                    ]
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'attr'       => [
                'class' => 'form-horizontal form-label-left'
            ]
        ]);
    }
}