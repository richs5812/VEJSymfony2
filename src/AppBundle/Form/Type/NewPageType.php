<?php

// src/AppBundle/Form/Type/PageType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class NewPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
			->add('pageType', ChoiceType::class, array(
				'choices' => array(
					'Page' => 'Page',
					'Blog' => 'Blog',
				)
			));
		$builder	
            ->add('content')
            //->add('galleryName')
			->add('content2')
			->add('includeInNav')
			->add('menuOrder')
			->add('sqlDate')
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

