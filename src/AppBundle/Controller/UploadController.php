<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\DocumentType;
use AppBundle\Entity\Document;

class UploadController extends Controller
{
    /**
     * @Route("/admin/upload", name="upload")
     */
    public function uploadAction(Request $request)
    {
		$document = new Document();

		$form = $this->createForm(DocumentType::class, $document, array('action' => $this->generateUrl('filesUpload')));

		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery('SELECT DISTINCT d.galleryName FROM AppBundle:Document d');
		$distinctGalleries = $query->getResult();

		//print_r($request->all());
		
		//$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			/*$em = $this->getDoctrine()->getManager();
  
			$em->persist($document);
			$em->flush();*/
			
			var_dump($form->getData());die;

			return $this->redirectToRoute('index');
		}

		return $this->render('default/upload.html.twig', array(
			'form' => $form->createView(),
			'distinctGalleries' => $distinctGalleries,
		));
	}
}
