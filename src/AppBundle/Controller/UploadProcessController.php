<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\HelloType;
use AppBundle\Form\Type\PageType;
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Response;
use Imagick;
use AppBundle\Entity\Page;


class UploadProcessController extends Controller
{
    /**
     * @Route("/admin/filesUpload", name="filesUpload")
     */
    public function uploadProcessAction(Request $request)
    {
    
		if ($request->request->getIterator()["GalleryName"] == "no gallery") {
			$galleryName = $request->request->getIterator()["document"]["galleryName"];
		} else {
			$galleryName = $request->request->getIterator()["GalleryName"];
		}
		$caption = $request->request->getIterator()["document"]["caption"];

		$filesArray = $request->files->getIterator()->current()["file"]; 
		 	
		$galleryName = trim($galleryName);

		foreach($filesArray as $file){
    		$document = new Document();	
    		if ($galleryName == "") {
    			$galleryName = NULL;
    		}
    		
			$document->setGalleryName($galleryName);
    		
			if ($caption == "") {
    			$document->setCaption(NULL);
    		} else {
				$document->setCaption($caption);
    		}
    		
    		$pubDate = date('D, d M Y H:i:s T');
    		$document->setPubDate($pubDate);

			$document->setFile($file);

			$em = $this->getDoctrine()->getManager();
  
			$em->persist($document);
			$em->flush();
			
			
			//dump($document->getPath());die;
			$documentPath = $document->getPath();
			
			//process image for slideshow and insert info into database
			try
			{
			// Open the original image
			$image = new \Imagick;
			$image->readImage('/Users/richsamartino/VEJSymfony/web/uploads/'.$documentPath);
			
			$orientation = $image->getImageOrientation();

				switch($orientation) {
					case imagick::ORIENTATION_BOTTOMRIGHT:
						$image->rotateimage("#000", 180); // rotate 180 degrees
					break;

					case imagick::ORIENTATION_RIGHTTOP:
						$image->rotateimage("#000", 90); // rotate 90 degrees CW
					break;

					case imagick::ORIENTATION_LEFTBOTTOM:
						$image->rotateimage("#000", -90); // rotate 90 degrees CCW
					break;
				}

				// Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
				$image->setImageOrientation(imagick::ORIENTATION_TOPLEFT); 

			$origSize = $image->getImageGeometry();
			$origWidth = $origSize['width'];
			$origHeight = $origSize['height'];

			if ($origWidth >= $origHeight){
				if ($origWidth > 1200){
				 $image->resizeImage(1200, 0, Imagick::FILTER_UNDEFINED, 1);
				 }
			} else {
				if ($origHeight > 1200){
				 $image->resizeImage(0, 1200, Imagick::FILTER_UNDEFINED, 1);
				 }
			}

			$resizedSize = $image->getImageGeometry();
			$resizedWidth = $resizedSize['width'];
			$resizedHeight = $resizedSize['height'];

			// Open the watermark
			$watermark = new \Imagick;
			$watermark->readImage('/Users/richsamartino/VEJSymfony/web/watermark/watermark_opacity60.png');

			$image->compositeImage($watermark, imagick::COMPOSITE_OVER, $resizedWidth-189, $resizedHeight-116);

			/* Create a drawing object and set the font size */
			$draw = new \ImagickDraw;

			/*** set the font ***/
			$draw->setFont( "/Library/Fonts/Tahoma.ttf" );

			/*** set the font size ***/
			$draw->setFontSize( 24 );

			/*** add some transparency ***/


			/*** set gravity to the center ***/
			$draw->setGravity( Imagick::GRAVITY_SOUTHEAST );
			$draw->setFillOpacity( 0.6 );
			$image->annotateImage( $draw, 22, 24, 0, "voices4earth.org" );
			/*** overlay the text on the image ***/
			$draw->setFillColor('white');
			   $draw->setFillOpacity( 0.6 );
			$image->annotateImage( $draw, 23, 23, 0, "voices4earth.org" );
	
			$image->setImageCompressionQuality(50);

			$target_slideshow_dir = '/Users/richsamartino/VEJSymfony/web/slideshow/'.$documentPath;

			/*** write image to disk ***/
			$image->writeImage( $target_slideshow_dir );


		}
		catch(Exception $e)
		{
				echo $e->getMessage();
		}

			//process image for thumbnail and insert info into database
			try
			{
			// Open the original image
			$thumbImage = new \Imagick;
			$thumbImage->readImage('/Users/richsamartino/VEJSymfony/web/uploads/'.$documentPath);
			
						$orientation = $thumbImage->getImageOrientation();

				switch($orientation) {
					case imagick::ORIENTATION_BOTTOMRIGHT:
						$thumbImage->rotateimage("#000", 180); // rotate 180 degrees
					break;

					case imagick::ORIENTATION_RIGHTTOP:
						$thumbImage->rotateimage("#000", 90); // rotate 90 degrees CW
					break;

					case imagick::ORIENTATION_LEFTBOTTOM:
						$thumbImage->rotateimage("#000", -90); // rotate 90 degrees CCW
					break;
				}

				// Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
				$thumbImage->setImageOrientation(imagick::ORIENTATION_TOPLEFT); 
				
			$origSize = $thumbImage->getImageGeometry();
			//$origWidth = $origSize['width'];
			//$origHeight = $origSize['height'];
			$thumbSize = $thumbImage->getImageGeometry();
			$thumbWidth = $origSize['width'];
			$thumbHeight = $origSize['height'];

			if ($thumbWidth >= $thumbHeight){
				 $thumbImage->thumbnailImage( 300, null );
			} else {
				 $thumbImage->thumbnailImage( null, 300 );
			}

			$target_thumbnail_dir = '/Users/richsamartino/VEJSymfony/web/thumb/'.$documentPath;

			/*** write image to disk ***/
			$thumbImage->writeImage( $target_thumbnail_dir);

		}
		catch(Exception $e)
		{
				echo $e->getMessage();
		}
		}
		
		//create blog post if requested
		if (isset($request->request->getIterator()["document"]["createBlog"]) == true){
			
			$page = new Page();
			$page->setGalleryName($galleryName);
			$page->setTitle($galleryName);
			
			//generate slug
			$slugNoHyphens = str_replace(" - "," ",$galleryName);
			$strippedSlug = preg_replace("/[^a-zA-Z0-9 ]/", "", $slugNoHyphens);
			$slug = str_replace(" ","-",$strippedSlug);
			$page->setSlug($slug);

			//date('D, d M Y H:i:s T');
			//$rssDate = $page->getSqlDate()->format('D, d M Y H:i:s T');
			$sqlDate = new \DateTime();
			$page->setPubDate(date('D, d M Y H:i:s T'));
			$page->setSqlDate($sqlDate);
			$page->setPageType('Blog');
			$page->setIncludeInNav(0);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($page);
			$em->flush();
		}
 	
    
		return $this->redirectToRoute('admin');
    }
}
