<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\PageType;
use AppBundle\Entity\Page;

class ShowGalleriesController extends Controller
{
    /**
     * @Route("/admin/showGalleries", name="showGalleries")
     */
    public function showGalleriesAction()
    {
    
		$em = $this->getDoctrine()->getManager();
		
		$query = $em->createQuery('SELECT DISTINCT d.galleryName FROM AppBundle:Document d WHERE d.galleryName IS NOT NULL ORDER BY d.galleryName ASC');
		$galleries = $query->getResult();

        return $this->render('default/showGalleries.html.twig',
        array('galleries' => $galleries)
        );
    }
}
