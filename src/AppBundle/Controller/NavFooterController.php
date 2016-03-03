<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

class NavFooterController extends Controller
{
    public function navFooterAction()
    {
		
		$em = $this->getDoctrine()->getManager();
		
		$navQuery = $em->createQuery('SELECT p FROM AppBundle:Page p WHERE p.includeInNav = :include ORDER BY p.menuOrder ASC');
		$navQuery->setParameter('include', '1');
		$navPages = $navQuery->getResult();
		
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
        return $this->render('default/navFooter.html.twig', array(
        	'childPages' => $childArray,
        	'parentPages' => $parentArray,
        	'parentPageNames' => $parentPageNames,
        ));
    }
}
