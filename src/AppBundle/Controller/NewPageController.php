<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\PageType;
use AppBundle\Entity\Page;

class NewPageController extends Controller
{
    /**
     * @Route("/admin/newPage", name="newPage")
     */
    public function newPageAction(Request $request)
    {
    
		$page = new Page();
		$adminForm = $this->createForm(PageType::class, $page);
		
		$adminForm->handleRequest($request);

		if ($adminForm->isSubmitted() && $adminForm->isValid()) {	
			
			//generate slug
			$slugNoHyphens = str_replace(" - "," ",$page->getTitle());
			$strippedSlug = preg_replace("/[^a-zA-Z0-9 ]/", "", $slugNoHyphens);
			$slug = str_replace(" ","-",$strippedSlug);
			$page->setSlug($slug);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($page);
			$em->flush();

			return $this->redirectToRoute('showPages');

		}
    
        // render form
        return $this->render('default/admin.html.twig', array(
            'adminForm' => $adminForm->createView(),
        ));
    }
}
