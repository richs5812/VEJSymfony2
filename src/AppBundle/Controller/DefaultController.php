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
    	
    	if ($slug == 'Blog') {
			return $this->forward('AppBundle:Blog:Blog');
    	}    	
    	
    	if ($slug == 'Photo-Galleries') {
			return $this->forward('AppBundle:GalleriesPage:GalleriesPage');
    	}
    	
		$repository = $this->getDoctrine()
		->getRepository('AppBundle:Page');
		$allPages = $repository->findByIncludeInNav(1);
		$page = $repository->findOneBySlug($slug);
		if (!$page) {
		throw $this->createNotFoundException('No page found for voices4earth.org/'.$slug);
		}
		
		$picsRepository = $this->getDoctrine()
		->getRepository('AppBundle:Document');
		
		$pics = $picsRepository->findByGalleryName($page->getGalleryName());
		
    	if ($slug == "Home") {
			return $this->render('default/home.html.twig',
			array('page' => $page, 'pics' => $pics)
			);
    	}

        return $this->render('default/index.html.twig',
        array('page' => $page, 'pics' => $pics)
        );
    }
}
