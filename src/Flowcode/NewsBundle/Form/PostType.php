<?php

namespace Flowcode\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Flowcode\MediaBundle\Form\MediaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
                ->add('video')
                ->add('abstract')
                ->add('category', EntityType::class, array(
                    'class' => "Amulen\ClassificationBundle\Entity\Category",
                    'choices' => $this->categoryService->findByRoot("post"),
                    'choice_label' => function($category, $key, $index) {
                        $prefix = "";
                        for($i = 0; $i < $category->getLvl(); $i++){
                            $prefix .= "-";
                        }
                        return strtolower($prefix.$category->getName());
                    },
                    'multiple' => false,
                ))
                ->add('content', 'ckeditor')
                ->add('enabled', null, array('required' => false))
                ->add('tags')
                ->add('published')
                ->add('position')
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
