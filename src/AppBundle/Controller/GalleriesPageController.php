<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleriesPageController extends Controller
{
    /**
     * @Route("/Photo-Galleries", name="photo-galleries")
     */
    public function galleriesPageAction(Request $request)
    {
    	
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT p
			FROM AppBundle:Page p
			WHERE p.galleryName != :name
			AND p.pageType = :pageType
			ORDER BY p.sqlDate DESC'
		)->setParameter('name', 'no gallery')
		->setParameter('pageType', 'Blog');
		
		//$galleries = $query->getResult();
		
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query, /* query NOT result */
			$request->query->getInt('page', 1)/*page number*/,
			5/*limit per page*/
		);
		
        // replace this example code with whatever you need
        return $this->render('default/galleriesPage.html.twig',
        //array('galleries' => $galleries)
		array('pagination' => $pagination)
        );
    }
}
