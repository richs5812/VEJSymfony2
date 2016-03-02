<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends Controller
{

    public function galleryAction($galleryName)
    {
		
		$picsRepository = $this->getDoctrine()
		->getRepository('AppBundle:Document');
		
		$pics = $picsRepository->findByGalleryName($galleryName);
		
        // replace this example code with whatever you need
        return $this->render('default/gallery.html.twig',
        array('pics' => $pics)
        );
    }
}
