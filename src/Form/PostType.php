<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{
    TextType, TextareaType
};

/**
 * Class PostType
 *
 * @package App\Form
 */
class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'category',
                EntityType::class,
                [
                    'class'         => Category::class,
                    'choice_label'  => 'name',
                    'query_builder' => function (CategoryRepository $repository) {
                        return $repository->createAlphabeticalQueryBuilder();
                    },
                    'required'      => true,
                    'label'         => 'Category*',
                    'placeholder'   => 'Choose a category',
                    'label_attr'    => [
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'attr'          => [
                        'class'       => 'form-control col-md-7 col-xs-12',
                        'placeholder' => 'Category'
                    ],
                ]
            )->add(
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
            )->add(
                'content',
                TextareaType::class,
                [
                    'required'   => true,
                    'label'      => 'Content*',
                    'label_attr' => [
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'attr'       => [
                        'class'       => 'form-control col-md-7 col-xs-12',
                        'placeholder' => 'Content'
                    ]
                ]
            )->add(
                'attachmentFile',
                VichFileType::class,
                [
                    'required'     => false,
                    'allow_delete' => true,
                    'label'        => 'File*',
                    'label_attr'   => [
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'attr'       => [
                'class' => 'form-horizontal form-label-left'
            ]
        ]);
    }
}