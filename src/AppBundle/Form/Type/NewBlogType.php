<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class NewBlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('excerpt')
            ->add('featuredPhoto', FileType::class, array('label' => 'Upload Featured Photo', 'required'=> false))
            ->add('content')
			->add('content2')
			->add('sqlDate', DateTimeType::class, array(
					'data' => new \DateTime()
				));
		$builder
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

