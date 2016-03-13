<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleriesPageController extends Controller
{
    public function galleriesPageAction()
    {
    	
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT p
			FROM AppBundle:Page p
			WHERE p.galleryName != :name
			ORDER BY p.sqlDate DESC'
		)->setParameter('name', 'no gallery');
		
		$galleries = $query->getResult();
		
        // replace this example code with whatever you need
        return $this->render('default/galleriesPage.html.twig',
        array('galleries' => $galleries)
        );
    }
}
