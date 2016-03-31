<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EditGalleryController extends Controller
{
    /**
     * @Route("/admin/editGallery/{galleryName}", name="editGallery")
     */
    public function editGalleryAction(Request $request, $galleryName)
    {
     	if(isset($request->query->getIterator()["UpdatePhoto"])) {
    		//dump($request->query->getIterator());die;
			$photo = $this->getDoctrine()
				->getRepository('AppBundle:Document')
				->findOneById($request->query->getIterator()["photoID"]);

			$caption = $request->query->getIterator()["imageCaption"];
			
			if ($caption == ""){
				$photo->setCaption(NULL);
			} else {
				$photo->setCaption($caption);
			}
			
			$sqlDate = date_create($request->query->getIterator()["PhotoDate"]);
			$sqlDate = $sqlDate->format('Y-m-d');
			$hour = $request->query->getIterator()["hour"];
			$minute = $request->query->getIterator()["minute"];
			//dump($sqlDate.' '.$hour.':'.$minute.':00');die;
			$sqlDate = new \DateTime($sqlDate.' '.$hour.':'.$minute.':00');
			//dump($sqlDate);die;
			$photo->setSqlDate($sqlDate);
						
			$pubDate = $sqlDate->format('D, d M Y H:i:s T');
			$photo->setPubDate($pubDate);
			
			$em = $this->getDoctrine()->getManager();

			$em->persist($photo);
			$em->flush();
			
    	}
    	
    	if(isset($request->query->getIterator()["DeletePhoto"])) {
			//dump($request->query->getIterator());die;
			
			$photo = $this->getDoctrine()
				->getRepository('AppBundle:Document')
				->findOneById($request->query->getIterator()["photoID"]);
				
			$em = $this->getDoctrine()->getManager();

			$em->remove($photo);
			$em->flush();
			
			return $this->redirectToRoute('showGalleries');

		}

		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT d
			FROM AppBundle:Document d
			WHERE d.galleryName = :name'
		)->setParameter('name', $galleryName);
		
		$galleryPhotos = $query->getResult();
		//dump($galleryPhotos);die;
        // replace this example code with whatever you need
        return $this->render('default/editGallery.html.twig',
        array('galleryPhotos' => $galleryPhotos)
        );
    }
}
