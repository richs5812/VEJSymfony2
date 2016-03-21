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
		}
		
		//dump($latestPhotos);die;

        return $this->render('default/latestPhotos.html.twig',
        array('latestPhotos' => $latestPhotos)
        );
    }
}
