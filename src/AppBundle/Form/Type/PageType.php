<?php

// src/AppBundle/Form/Type/PageType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
			->add('pageType')
            ->add('content')
            ->add('galleryName')
			->add('content2')
			->add('includeInNav')
			->add('isParent')
			->add('parentPage')
			->add('sqlDate')
            ->add('slug')
            ->add('save', SubmitType::class)
        ;
    }

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'AppBundle\Entity\Page',
    ));
}
}

