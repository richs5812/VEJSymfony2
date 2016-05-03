<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends Controller
{

    public function galleryAction($galleryName)
    {
		
		$em = $this->getDoctrine()->getManager();
		
		$query = $em->createQuery(
			'SELECT d
			FROM AppBundle:Document d
			WHERE d.galleryName = :galleryName
			ORDER BY d.sqlDate ASC'
		);
		$query->setParameter('galleryName', $galleryName);
		
		$pics = $query->getResult();
		
		//$pics = $picsRepository->findByGalleryName($galleryName);
		
        // replace this example code with whatever you need
        return $this->render('default/gallery.html.twig',
        array('pics' => $pics)
        );
    }
}
