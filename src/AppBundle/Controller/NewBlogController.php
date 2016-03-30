<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\NewBlogType;
use AppBundle\Entity\Page;

class NewBlogController extends Controller
{
    /**
     * @Route("/admin/newBlog", name="newBlog")
     */
    public function newBlogAction(Request $request)
    {
    
		$page = new Page();

		$form = $this->createForm(NewBlogType::class, $page);

		$em = $this->getDoctrine()->getManager();
		
		$query = $em->createQuery('SELECT DISTINCT d.galleryName FROM AppBundle:Document d WHERE d.galleryName IS NOT NULL ORDER BY d.galleryName ASC');
		$distinctPages = $query->getResult();
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {	
		
			$galleryName = $request->request->getIterator()["GalleryName"];
			if ($galleryName == 'no gallery') {
				$galleryName = null;
			}
			$page->setGalleryName($galleryName);

			$page->setPageType("Blog");
			
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $page->getFeaturedPhoto();
            
            if ($file != NULL){
				// Generate a unique name for the file before saving it
				$fileName = md5(uniqid()).'.'.$file->guessExtension();

				$file = $page->createFeaturedPhoto($file);
			
				// Move the file to the directory where brochures are stored
				$featuredPhotoDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/featuredPhotos/';
				$file->writeImage($featuredPhotoDir.$fileName);

				// Update the 'brochure' property to store the PDF file name
				// instead of its contents
				$page->setFeaturedPhotoName($fileName);
				$page->setFeaturedPhoto(NULL);
			}
			//generate slug
			$slugNoHyphens = str_replace(" - "," ",$page->getTitle());
			$strippedSlug = preg_replace("/[^a-zA-Z0-9 ]/", "", $slugNoHyphens);
			$slug = str_replace(" ","-",$strippedSlug);
			$page->setSlug($slug);
			
			$rssDate = $page->getSqlDate()->format('D, d M Y H:i:s T');
		
			$page->setPubDate($rssDate);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($page);
			$em->flush();

			$slug = $page->getSlug();

			return $this->redirectToRoute('editBlog', array('slug'=> $slug));
		}
    
        // render form
        return $this->render('default/newBlog.html.twig', array(
            'form' => $form->createView(),
            'distinctPages' => $distinctPages,
        ));
    }
}
