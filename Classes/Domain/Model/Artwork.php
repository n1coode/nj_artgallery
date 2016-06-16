<?php
namespace N1coode\NjArtgallery\Domain\Model;

/**
 * An artwork
 * @author n1coode
 * @package nj_artgallery
 */
class Artwork extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var \N1coode\NjArtgallery\Domain\Model\Artist
     */
    protected $artist;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkCat>
     * @lazy
     * @cascade remove
     */
    protected $category;

	
	
    /**
     * @var string
     */
    protected $creation;

	/**
	 * @var string 
	 */
	protected $creationLocation;
	
	/**
	 * @var int 
	 */
	protected $creationFinished;
	
	/**
	 * @var int 
	 */
	protected $creationStart;
	
	
	
    /**
     * @var int
     */
    protected $height;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $image;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkMedium>
     * @lazy
     * @cascade remove
     */
    protected $media;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkMotive>
     * @lazy
     * @cascade remove
     */
    protected $motives;

    /**
     * @var int
     */
    protected $onSale;

	/**
	 * @var double2
	 */
	protected $price;
	
    /**
     * @var int
     */
    protected $showcase;

	/**
	 * @var int 
	 */
	protected $showPrice;
	
    /**
     * @var int
     */
    protected $sold;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkTech>
     * @lazy
     * @cascade remove
     */
    protected $techniques;

    /**
     * @var string
     * @validate StringLength(minimum = 3, maximum = 255)
     */
    protected $title;

    /**
     * @var int
     */
    protected $width;
	
	
    /* ***************************************************** */

    /**
     * Constructs a new artwork
     * @return AbstractObject
     */
    public function __construct() {

    }

    /* ***************************************************** */
	
	
    /**
     * Getter for the artist
     *
     * @return \N1coode\NjArtgallery\Domain\Model\Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Setter for the artist
     *
     * @param \N1coode\NjArtgallery\Domain\Model\Artist $artist
     * @return void
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }
	
	
    /**
     * Getter for the category
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkCat> $category
     *
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Setter for the category
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkCat> $category
     * @return void
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
	
	
    /**
     * @return string
     */
    public function getCreation()
    {
		$this->creation = '';
		if($this->creationStart > 0) {
			$this->creation .= $this->creationStart;
			
			if($this->creationFinished > 0)
			{
				$this->creation .= ' - ';
			}
		}
		if($this->creationFinished > 0) {
			$this->creation .= $this->creationFinished;
			
			if($this->creationLocation !== NULL)
			{
				$this->creation .= ', ';
			}
		}
		if($this->creationLocation !== NULL) {
			$this->creation .= $this->creationLocation;
		}
        return $this->creation;
    }

	
	/**
     * @return string
     */
    public function getCreationLocation()
    {
        return $this->creationLocation;
    }

    /**
     * @param string
     * @return void
     */
    public function setCreationLocation($creationLocation)
    {
        $this->creationLocation = $creationLocation;
    }
	
	
	/**
     * @return int
     */
    public function getCreationFinished()
    {
        return $this->creationFinished;
    }

    /**
     * @param int
     * @return void
     */
    public function setCreationFinished($creationFinished)
    {
        $this->creationfinished = $creationFinished;
    }
	
 
	/**
     * @return int
     */
    public function getCreationStart()
    {
        return $this->creationStart;
    }

    /**
     * @param int
     * @return void
     */
    public function setCreationStart($creationStart)
    {
        $this->creationStart = $creationStart;
    }
	
	
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
	
	
    /**
     * Getter for the height
     *
     * @return int $height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Setter for the height
     *
     * @param int $height
     * @return void
     * @api
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }
	
    
    /**
	 * Returns the image
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
	 * @return void
	 */
	public function setImage($image) 
	{
		$this->image = $image;
	}

	
    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkMedium>
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkMedium> $media
     * @return void
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }
	
	
    /**
     * Getter for the motive
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkMotive> $motives
     *
     */
    public function getMotives()
    {
        return $this->motives;
    }

    /**
     * Setter for the motive
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkMotive> $motives
     * @return void
     */
    public function setMotives($motives)
    {
        $this->motives = $motives;
    }
	
    
	/**
     * @return double2
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param double2 $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
        
    /**
     * Getter for the showcase option
     *
     * @return int
     */
    public function getShowcase()
    {
        return $this->showcase;
    }

    /**
     * Setter for the showcase option
     *
     * @param int $showcase
     * @return void
     * @api
     */
    public function setShowcase($showcase)
    {
        $this->showcase = $showcase;
    }
    
	
	/**
     * @return int
     */
    public function getShowPrice()
    {
        return $this->showPrice;
    }

    /**
     * @param int $showPrice
     * @return void
     */
    public function setShowPrice($showPrice)
    {
        $this->showPrice = $showPrice;
    }
	
    
    /**
     * Getter for sold status
     *
     * @return int
     */
    public function getSold()
    {
        return $this->sold;
    }

    /**
     * Setter for sold status
     *
     * @param int $sold
     * @return void
     * @api
     */
    public function setSold($sold)
    {
        $this->sold = $sold;
    }
	
	
    /**
     * Getter for the used techniques
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkTech> $techniques
     *
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     * Setter for the used techniques
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkTech> $techniques
     * @return void
     */
    public function setTechniques($techniques)
    {
        $this->techniques = $techniques;
    }
	
	
    /**
     * Getter for the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Setter for the title
     *
     * @param string $title
     * @return void
     */
    public function setTtitle($title)
    {
        $this->title = $title;
    }
	
	
	/**
     * @return string
     */
    public function getOnSale()
    {
        return $this->onSale;
    }

    /**
     * @param string $onSale
     * @return void
     */
    public function setOnSale($onSale)
    {
        $this->onSale = $onSale;
    }
	
	
    /**
     * Getter for width
     *
     * @return int $width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Setter for width
     *
     * @param int $width
     * @return void
     * @api
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }
	
} //end of class N1coode\NjArtgallery\Domain\Model\Artwork