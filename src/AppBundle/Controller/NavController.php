<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

class NavController extends Controller
{
    public function navAction()
    {
		$repository = $this->getDoctrine()
		->getRepository('AppBundle:Page');
		$navPages = $repository->findByIncludeInNav(1);
		
		$childArray = new ArrayCollection();
		$parentArray = new ArrayCollection();
		$parentPageNames = new ArrayCollection();
		
		foreach ($navPages as $navPage){
			if ($navPage->getParentPage() != null){
				$childArray->add($navPage);
				$parentPageNames->add($navPage->getParentPage());
			} else {
				$parentArray->add($navPage);
			}
		}
		
        // replace this example code with whatever you need
        return $this->render('default/nav.html.twig', array(
        	'childPages' => $childArray,
        	'parentPages' => $parentArray,
        	'parentPageNames' => $parentPageNames,
        ));
    }
}
