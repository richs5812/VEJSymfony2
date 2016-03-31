<?php

// src/AppBundle/Form/Type/DocumentType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('galleryName')
			->add('createBlog')
			->add('caption')
			->add('file', FileType::class, array('multiple' => true))
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
			'data_class' => 'AppBundle\Entity\Document',
		));
	}
}

?>
