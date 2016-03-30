<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LatestPhotosController extends Controller
{
    /**
     * @Route("/latest/photos")
     */
    public function latestPhotosAction()
    {
    		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT d
			FROM AppBundle:Document d
			ORDER BY d.pubDate DESC'
		);

		$photos = $query->getResult();

		$numPhotos = 8;
		
		$latestPhotos = array();
		
		for ($i = 0; $i < $numPhotos; $i++){
			$latestPhotos[$i] = $photos[$i];
		
			$query = $em->createQuery(
				'SELECT p
				FROM AppBundle:Page p
				WHERE p.galleryName = :galleryName'
			)->setParameter('galleryName', $photos[$i]->getGalleryName());
			
			//dump($query->getResult());die;
			
			$galleryPage = $query->getResult();
			$latestPhotos[$i]->setGallerySlug($galleryPage[0]->getSlug());
		}
		
		//dump($galleryPage);die;

        return $this->render('default/latestPhotos.html.twig',
        array('latestPhotos' => $latestPhotos)
        );
    }
}
