<?php

namespace Flowcode\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Flowcode\MediaBundle\Form\MediaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Amulen\ClassificationBundle\Entity\Category;

class PostType extends AbstractType {

    private $categoryService;

    public function __construct($categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title')
                ->add('image')
                ->add('abstract')
                ->add('category', ChoiceType::class, array(
                    'data_class' => "Amulen\ClassificationBundle\Entity\Category",
                    'choices' => $this->categoryService->findByRoot("post"),
                    /* Para usar en Productos!!
                    'choice_attr' => function($category, $key, $index) {
                        $prefix = "";
                        for($i = 0; $i < $category->getLevel(); $i++){
                            $prefix .= "-";
                        }
                        return ['class' => 'category_'.strtolower($category->getName())];
                    },
                    'choice_label' => 'description',*/
                    'multiple' => false,
                ))
                ->add('content', 'ckeditor')
                ->add('enabled', null, array('required' => false))
                ->add('tags')
                ->add('published')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Amulen\NewsBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'flowcode_newsbundle_post';
    }

}
