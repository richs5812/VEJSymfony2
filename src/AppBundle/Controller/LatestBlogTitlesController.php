<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LatestBlogTitlesController extends Controller
{

    public function latestBlogTitlesAction()
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

		$numBlogs = 5;
		
		$latestBlogs = array();
		
		for ($i = 0; $i < $numBlogs; $i++){
			$latestBlogs[$i] = $blogs[$i];
		}
		
		//dump($latestPhotos);die;

        return $this->render('default/latestBlogTitles.html.twig',
        array('latestBlogs' => $latestBlogs)
        );
    }
}
