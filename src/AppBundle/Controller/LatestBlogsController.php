<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LatestBlogsController extends Controller
{
    /**
     * @Route("/latest/blogs")
     */
    public function latestBlogsAction()
    {
    		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT p
			FROM AppBundle:Page p
			WHERE p.pageType = :pageType
			ORDER BY p.sqlDate DESC'
		);
		$query->setParameter('pageType', 'Blog');
		$blogs = $query->getResult();

		$numBlogs = 3;
		
		$latestBlogs = array();
		
		for ($i = 0; $i < $numBlogs; $i++){
			$latestBlogs[$i] = $blogs[$i];
		}
		
		//dump($latestPhotos);die;

        return $this->render('default/latestBlogs.html.twig',
        array('latestBlogs' => $latestBlogs)
        );
    }
}
