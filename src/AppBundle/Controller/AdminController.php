<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\PageType;
use AppBundle\Entity\Page;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function showPagesAction()
    {
    
		$repository = $this->getDoctrine()
		->getRepository('AppBundle:Page');
		
		//$pages = $repository->findAll();
		$em = $this->getDoctrine()->getManager();

		$pagesQuery = $em->createQuery('SELECT p FROM AppBundle:Page p WHERE p.pageType = :pageType ORDER BY p.title ASC');
		$pagesQuery->setParameter('pageType', 'Page');
		$pages = $pagesQuery->getResult();

		$blogsQuery = $em->createQuery('SELECT p FROM AppBundle:Page p WHERE p.pageType = :pageType ORDER BY p.title ASC');
		$blogsQuery->setParameter('pageType', 'Blog');
		$blogs = $blogsQuery->getResult();

        // replace this example code with whatever you need
        return $this->render('default/showPages.html.twig', array(
        'pages' => $pages,
		'blogs' => $blogs,
        ));
    }
}
