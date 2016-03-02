<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/{slug}", defaults={"slug" = "Home"}, name="index", requirements={"slug": "^(?!.*login|admin).*$"})
     */
    public function indexAction($slug)
    {	
    	if ($slug == null) {
    		$slug = "Home";
    	}
    	
		$repository = $this->getDoctrine()
		->getRepository('AppBundle:Page');
		$allPages = $repository->findByIncludeInNav(1);
		$page = $repository->findOneBySlug($slug);
		
		$picsRepository = $this->getDoctrine()
		->getRepository('AppBundle:Document');
		
		$pics = $picsRepository->findByGalleryName($page->getGalleryName());
		
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig',
        array('page' => $page, 'pics' => $pics)
        );
    }
}
