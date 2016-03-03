<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\EditPageType;
use AppBundle\Form\Type\PageType;
use AppBundle\Entity\Page;

class EditPageController extends Controller
{
    /**
     * @Route("/admin/editPage/{slug}", name="editPage")
     */
    public function editPageAction(Request $request, $slug)
    {
    
		$repository = $this->getDoctrine()
		->getRepository('AppBundle:Page');
		
		$page = $repository->findOneBySlug($slug);
		//$parentPages = $repository->findByParentPage(null);
		
		$em = $this->getDoctrine()->getManager();
		
		$parentQuery = $em->createQuery('SELECT p.title FROM AppBundle:Page p WHERE p.parentPage IS NULL AND p.pageType = :pageType');
		$parentQuery->setParameter('pageType', 'Page');
		$parentPages = $parentQuery->getResult();
		
		$query = $em->createQuery('SELECT DISTINCT d.galleryName FROM AppBundle:Document d');
		$distinctPages = $query->getResult();
		
		$form = $this->createForm(EditPageType::class, $page);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {	
			$galleryName = $request->request->getIterator()["GalleryName"];
			$page->setGalleryName($galleryName);
			
			$parentPage = $request->request->getIterator()["ParentPage"];
			if ($parentPage == 'no parent page'){
				$parentPage = NULL;
			}
			$page->setParentPage($parentPage);
			
			$rssDate = $page->getSqlDate()->format('D, d M Y H:i:s T');
			$page->setPubDate($rssDate);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($page);
			$em->flush();

			return $this->redirectToRoute('admin');

		}
    
        // render form
        return $this->render('default/editPage.html.twig', array(
            'form' => $form->createView(),
            'distinctPages' => $distinctPages,
            'page' => $page,
            'parentPages' => $parentPages,
        ));
    }
}
