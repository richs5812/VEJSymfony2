<?php

	// src/AppBundle/Entity/Page.php
	namespace AppBundle\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\Validator\Constraints as Assert;
	use Imagick;
	
	/**
	 * @ORM\Entity
	 * @ORM\Table(name="Page")
	 */
	class Page
	{	
	
		/**
		 * @ORM\Column(type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		*/
		protected $id;
		
		/**
		 * @ORM\Column(type="string", length=200)
	     * @Assert\NotNull()
		 */
		protected $title;
		
		/**
		 * @ORM\Column(type="text", nullable=true)
		 */		
		protected $content;
		
		/**
		 * @ORM\Column(type="string", length=200, nullable=true)
		 */
		protected $galleryName;
		
		/**
		 * @ORM\Column(type="text", nullable=true)
		 */		
		protected $content2;
		
		/**
		 * @ORM\Column(type="text", nullable=true)
		 */		
		protected $excerpt;
		
		/**
		 * @ORM\Column(type="boolean", nullable=true)
		 */		
		protected $includeInNav;
		
		/**
		 * @ORM\Column(type="integer", nullable=true)
		 */		
		protected $menuOrder;
		
		/**
		 * @ORM\Column(type="string", length=200, nullable=true)
		 */
		protected $slug;
		
		/**
		 * @ORM\Column(type="string", length=100, nullable=true)
		 */
		protected $pubDate;
		
		/**
		 * @ORM\Column(type="datetime", nullable=true)
		 */		
		protected $sqlDate;

		/**
		 * @ORM\Column(type="string", length=200, nullable=true)
		 */
		protected $pageType;

		/**
		 * @ORM\Column(type="string", length=100, nullable=true)
		 */
		protected $parentPage;

		/**
		 * @ORM\Column(type="string", nullable=true)
		 */
		private $featuredPhoto;
		
		/**
		 * @ORM\Column(type="string", nullable=true)
		 */
		private $featuredPhotoName;

	// create featured photo image
	public function createFeaturedPhoto($file)
	{
			try
			{
			// Open the original image
			$featuredPhoto = new \Imagick;
			$featuredPhoto->readImage($file);
			
				$orientation = $featuredPhoto->getImageOrientation();

				switch($orientation) {
					case imagick::ORIENTATION_BOTTOMRIGHT:
						$featuredPhoto->rotateimage("#000", 180); // rotate 180 degrees
					break;

					case imagick::ORIENTATION_RIGHTTOP:
						$featuredPhoto->rotateimage("#000", 90); // rotate 90 degrees CW
					break;

					case imagick::ORIENTATION_LEFTBOTTOM:
						$featuredPhoto->rotateimage("#000", -90); // rotate 90 degrees CCW
					break;
				}

				// Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
				$featuredPhoto->setImageOrientation(imagick::ORIENTATION_TOPLEFT); 

			$thumbSize = $featuredPhoto->getImageGeometry();
			$thumbWidth = $thumbSize['width'];
			$thumbHeight = $thumbSize['height'];

			if ($thumbWidth >= $thumbHeight){
				 $featuredPhoto->thumbnailImage( 300, null );
			} else {
				 $featuredPhoto->thumbnailImage( null, 300 );
			}

			return $featuredPhoto;

		}
		catch(Exception $e)
		{
				echo $e->getMessage();
		}	
	}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set galleryName
     *
     * @param string $galleryName
     *
     * @return Page
     */
    public function setGalleryName($galleryName)
    {
        $this->galleryName = $galleryName;

        return $this;
    }

    /**
     * Get galleryName
     *
     * @return string
     */
    public function getGalleryName()
    {
        return $this->galleryName;
    }

    /**
     * Set content2
     *
     * @param string $content2
     *
     * @return Page
     */
    public function setContent2($content2)
    {
        $this->content2 = $content2;

        return $this;
    }

    /**
     * Get content2
     *
     * @return string
     */
    public function getContent2()
    {
        return $this->content2;
    }

    /**
     * Set includeInNav
     *
     * @param boolean $includeInNav
     *
     * @return Page
     */
    public function setIncludeInNav($includeInNav)
    {
        $this->includeInNav = $includeInNav;

        return $this;
    }

    /**
     * Get includeInNav
     *
     * @return boolean
     */
    public function getIncludeInNav()
    {
        return $this->includeInNav;
    }

    /**
     * Set pubDate
     *
     * @param string $pubDate
     *
     * @return Page
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * Get pubDate
     *
     * @return string
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Set sqlDate
     *
     * @param \DateTime $sqlDate
     *
     * @return Page
     */
    public function setSqlDate($sqlDate)
    {
        $this->sqlDate = $sqlDate;

        return $this;
    }

    /**
     * Get sqlDate
     *
     * @return \DateTime
     */
    public function getSqlDate()
    {
        return $this->sqlDate;
    }

    /**
     * Set pageType
     *
     * @param string $pageType
     *
     * @return Page
     */
    public function setPageType($pageType)
    {
        $this->pageType = $pageType;

        return $this;
    }

    /**
     * Get pageType
     *
     * @return string
     */
    public function getPageType()
    {
        return $this->pageType;
    }

    /**
     * Set parentPage
     *
     * @param string $parentPage
     *
     * @return Page
     */
    public function setParentPage($parentPage)
    {
        $this->parentPage = $parentPage;

        return $this;
    }

    /**
     * Get parentPage
     *
     * @return string
     */
    public function getParentPage()
    {
        return $this->parentPage;
    }

    /**
     * Set menuOrder
     *
     * @param integer $menuOrder
     *
     * @return Page
     */
    public function setMenuOrder($menuOrder)
    {
        $this->menuOrder = $menuOrder;

        return $this;
    }

    /**
     * Get menuOrder
     *
     * @return integer
     */
    public function getMenuOrder()
    {
        return $this->menuOrder;
    }

    /**
     * Set excerpt
     *
     * @param string $excerpt
     *
     * @return Page
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Get excerpt
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Set featuredPhoto
     *
     * @param string $featuredPhoto
     *
     * @return Page
     */
    public function setFeaturedPhoto($featuredPhoto)
    {
        $this->featuredPhoto = $featuredPhoto;

        return $this;
    }

    /**
     * Get featuredPhoto
     *
     * @return string
     */
    public function getFeaturedPhoto()
    {
        return $this->featuredPhoto;
    }

    /**
     * Set featuredPhotoName
     *
     * @param string $featuredPhotoName
     *
     * @return Page
     */
    public function setFeaturedPhotoName($featuredPhotoName)
    {
        $this->featuredPhotoName = $featuredPhotoName;

        return $this;
    }

    /**
     * Get featuredPhotoName
     *
     * @return string
     */
    public function getFeaturedPhotoName()
    {
        return $this->featuredPhotoName;
    }
}
