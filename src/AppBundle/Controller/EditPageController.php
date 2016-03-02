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
		
		$adminForm = $this->createForm(PageType::class, $page);
		
		$adminForm->handleRequest($request);

		if ($adminForm->isSubmitted() && $adminForm->isValid()) {	
			
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
