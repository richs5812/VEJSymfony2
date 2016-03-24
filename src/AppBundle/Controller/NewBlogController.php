<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\NewPageType;
use AppBundle\Entity\Page;

class NewPageController extends Controller
{
    /**
     * @Route("/admin/newBlog", name="newBlog")
     */
    public function newPageAction(Request $request)
    {
    
		$page = new Page();

		$form = $this->createForm(NewPageType::class, $page);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {	
			$galleryName = $request->request->getIterator()["GalleryName"];
			if ($galleryName == 'no gallery') {
				$galleryName = null;
			}
			$page->setGalleryName($galleryName);
			
			$parentPage = $request->request->getIterator()["ParentPage"];
			if ($parentPage == 'no parent page'){
				$parentPage = NULL;
			}
			$page->setParentPage($parentPage);
			
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

			return $this->redirectToRoute('admin');

		}
    
        // render form
        return $this->render('default/newPage.html.twig', array(
            'form' => $form->createView(),
            'distinctPages' => $distinctPages,
            'parentPages' => $parentPages,
        ));
    }
}
