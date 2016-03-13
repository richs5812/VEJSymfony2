<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SlideshowController extends Controller
{
    /**
     * @Route("/showSlideshow/{picPath}", defaults={"picPath" = "pic"}, name="slideshow")
     */
    public function slideshowAction($picPath)
    {
		
		$picsRepository = $this->getDoctrine()
		->getRepository('AppBundle:Document');
		
		$pic = $picsRepository->findOneByPath($picPath);
		
		$galleryPics = $picsRepository->findByGalleryName($pic->getGalleryName());
		$count = count($galleryPics);
		
		for ($i = 0; $i < $count; $i++){
			if ($galleryPics[$i]->getPath() == $picPath){
				$index = $i;
			}
		}

		if ($index == 0){
			$nextIndex = $index + 1;
			$previousIndex = $count - 1;
		} elseif ($index == ($count - 1)) {
			$nextIndex = 0;
			$previousIndex = $index - 1;
		} else {
			$nextIndex = $index + 1;
			$previousIndex = $index - 1;
		}
		
		if ($count == 1) {
			$nextIndex = 0;
			$previousIndex = 0;
		}
		
		$nextPic = $galleryPics[$nextIndex];
		$previousPic = $galleryPics[$previousIndex];
		
		//dump($galleryPics[1]->getPath());die;

		//dump(array_search($picPath,$galleryPics));die;
		
        // replace this example code with whatever you need
        return $this->render('default/slideshow.html.twig',
        array(
			'pic' => $pic,
			'nextPic' => $nextPic,
			'previousPic' => $previousPic,
			'count' => $count,
        ));
    }
}

?>
