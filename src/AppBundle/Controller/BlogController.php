<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/Blog", name="blog")
     */
    public function blogAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
		
		$blogQuery = $em->createQuery('SELECT p FROM AppBundle:Page p WHERE p.pageType = :pageType ORDER BY p.sqlDate DESC');
		$blogQuery->setParameter('pageType', 'Blog');
		//$blogs = $blogQuery->getResult();
		
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$blogQuery, /* query NOT result */
			$request->query->getInt('page', 1)/*page number*/,
			5/*limit per page*/
		);
		
        return $this->render('default/blog.html.twig',
        //array('blogs' => $blogs)
        array('pagination' => $pagination)
        );
    }
}
