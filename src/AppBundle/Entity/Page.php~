<?php

	// src/AppBundle/Entity/Page.php
	namespace AppBundle\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\Validator\Constraints as Assert;
	
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
		 * @ORM\Column(type="string", length=200, nullable=true)
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
		 * @ORM\Column(type="boolean", nullable=true)
		 */		
		protected $includeInNav;
		
		/**
		 * @ORM\Column(type="boolean", nullable=true)
		 */		
		protected $isParent;
		
		/**
		 * @ORM\Column(type="string", length=200, nullable=true)
		 */
		protected $slug;
		
		/**
		 * @ORM\Column(type="string", length=100, nullable=true)
		 */
		protected $pubDate;
		
		/**
		 * @ORM\Column(type="date", nullable=true)
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
     * Set isParent
     *
     * @param boolean $isParent
     *
     * @return Page
     */
    public function setIsParent($isParent)
    {
        $this->isParent = $isParent;

        return $this;
    }

    /**
     * Get isParent
     *
     * @return boolean
     */
    public function getIsParent()
    {
        return $this->isParent;
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
}
