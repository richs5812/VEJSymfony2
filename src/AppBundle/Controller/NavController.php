<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NavController extends Controller
{
    public function navAction()
    {
    	
		$repository = $this->getDoctrine()
		->getRepository('AppBundle:Page');
		$navPages = $repository->findByIncludeInNav(1);
		
        // replace this example code with whatever you need
        return $this->render('default/nav.html.twig',
        array('navPages' => $navPages)
        );
    }
}
