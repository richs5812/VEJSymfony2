<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\EditBlogType;
use AppBundle\Entity\Page;

class EditBlogController extends Controller
{
    /**
     * @Route("/admin/editBlog/{slug}", name="editBlog")
     */
    public function editBlogAction(Request $request, $slug)
    {
    
		$repository = $this->getDoctrine()
		->getRepository('AppBundle:Page');
		
		$page = $repository->findOneBySlug($slug);
		//$parentPages = $repository->findByParentPage(null);
		
		$em = $this->getDoctrine()->getManager();
		
		$query = $em->createQuery('SELECT DISTINCT d.galleryName FROM AppBundle:Document d WHERE d.galleryName IS NOT NULL ORDER BY d.galleryName ASC');
		$distinctPages = $query->getResult();
		
		$form = $this->createForm(EditBlogType::class, $page);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {	
			if(isset($request->request->getIterator()["DeleteBlog"])) {
				
				$em = $this->getDoctrine()->getManager();

				$em->remove($page);
				$em->flush();
			
				return $this->redirectToRoute('admin');

			}

			// $file stores the uploaded PDF file
			/** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
			$file = $page->getFeaturedPhoto();
			if ($file != NULL){	
				
				// Generate a unique name for the file before saving it
				$fileName = md5(uniqid()).'.'.$file->guessExtension();
			
				// Move the file to the directory where brochures are stored
				$featuredPhoroDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/featuredPhotos';
				$file->move($featuredPhoroDir, $fileName);

				// Update the 'brochure' property to store the PDF file name
				// instead of its contents
				$page->setFeaturedPhotoName($fileName);
				$page->setFeaturedPhoto(NULL);
            }
			
			//dump($request);die;
			$galleryName = $request->request->getIterator()["GalleryName"];
			if ($galleryName == "") {
				$galleryName = null;
			}
			$page->setGalleryName($galleryName);
			
			$rssDate = $page->getSqlDate()->format('D, d M Y H:i:s T');
			$page->setPubDate($rssDate);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($page);
			$em->flush();

		}
    
        // render form
        return $this->render('default/editBlog.html.twig', array(
            'form' => $form->createView(),
            'distinctPages' => $distinctPages,
            'page' => $page,
        ));
    }
}
