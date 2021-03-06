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
		
		$parentQuery = $em->createQuery('SELECT p.title FROM AppBundle:Page p WHERE p.parentPage IS NULL AND p.pageType = :pageType ORDER BY p.title ASC');
		$parentQuery->setParameter('pageType', 'Page');
		$parentPages = $parentQuery->getResult();
		
		$query = $em->createQuery('SELECT DISTINCT d.galleryName FROM AppBundle:Document d WHERE d.galleryName IS NOT NULL ORDER BY d.galleryName ASC');
		$distinctPages = $query->getResult();
		
		$form = $this->createForm(EditPageType::class, $page);
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if(isset($request->request->getIterator()["DeletePage"])) {
				
				$em = $this->getDoctrine()->getManager();

				$em->remove($page);
				$em->flush();
			
				return $this->redirectToRoute('admin');

			}
				
			$galleryName = $request->request->getIterator()["GalleryName"];
			if ($galleryName == "") {
				$galleryName = null;
			}
			$page->setGalleryName($galleryName);
			
			$parentPage = $request->request->getIterator()["ParentPage"];
			if ($parentPage == 'no parent page'){
				$parentPage = NULL;
			}
			$page->setParentPage($parentPage);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($page);
			$em->flush();

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
