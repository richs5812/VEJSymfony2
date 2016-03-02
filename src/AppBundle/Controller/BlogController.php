<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function blogAction()
    {
    	
		$repository = $this->getDoctrine()
		->getRepository('AppBundle:Page');
		$blogs = $repository->findByPageType('Blog');
				
        // replace this example code with whatever you need
        return $this->render('default/blog.html.twig',
        array('blogs' => $blogs)
        );
    }
}
