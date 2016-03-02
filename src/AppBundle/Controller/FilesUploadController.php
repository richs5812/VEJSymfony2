<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\HelloType;
use AppBundle\Form\Type\PageType;
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Response;

class FilesUploadController extends Controller
{
    /**
     * @Route("/admin/filesUpload", name="filesUpload")
     */
    public function helloAction(Request $request)
    {

    	$filesArray = $request->files->getIterator()->current()["file"];  	
		$galleryName = $request->request->getIterator()->current()["galleryName"];
		
		foreach($filesArray as $file){
    		$document = new Document();			
			$document->setGalleryName($galleryName);
			$document->setFile($file);
			$em = $this->getDoctrine()->getManager();
  
			$em->persist($document);
			$em->flush();
		} 	
    
		return $this->redirectToRoute('admin');
    }
}
