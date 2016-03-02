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
     * @Route("/admin/newPage", name="newPage")
     */
    public function newPageAction(Request $request)
    {
    
		$page = new Page();
		$form = $this->createForm(NewPageType::class, $page);

		$em = $this->getDoctrine()->getManager();
		
		$parentQuery = $em->createQuery('SELECT p.title FROM AppBundle:Page p WHERE p.parentPage IS NULL AND p.pageType = :pageType');
		$parentQuery->setParameter('pageType', 'Page');
		$parentPages = $parentQuery->getResult();
		
		$query = $em->createQuery('SELECT DISTINCT d.galleryName FROM AppBundle:Document d');
		$distinctPages = $query->getResult();
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {	
			$galleryName = $request->request->getIterator()["GalleryName"];
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
