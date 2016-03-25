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
    		
			$photo = $this->getDoctrine()
				->getRepository('AppBundle:Document')
				->findOneById($request->query->getIterator()["photoID"]);

			$photo->setCaption($request->query->getIterator()["imageCaption"]);
			
			$em = $this->getDoctrine()->getManager();

			$em->persist($photo);
			$em->flush();
									
			return $this->redirectToRoute('showGalleries');

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
