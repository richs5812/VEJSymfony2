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
    public function blogAction()
    {
    	$em = $this->getDoctrine()->getManager();
		
		$blogQuery = $em->createQuery('SELECT p FROM AppBundle:Page p WHERE p.pageType = :pageType ORDER BY p.sqlDate DESC');
		$blogQuery->setParameter('pageType', 'Blog');
		$blogs = $blogQuery->getResult();
		/*
		$repository = $this->getDoctrine()
		->getRepository('AppBundle:Page');
		$blogs = $repository->findByPageType('Blog');*/
				
        // replace this example code with whatever you need
        return $this->render('default/blog.html.twig',
        array('blogs' => $blogs)
        );
    }
}
