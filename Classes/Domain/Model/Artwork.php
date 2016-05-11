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
     * @var int
     */
    protected $cryear;

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
    protected $medium;

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
     * @var int
     */
    protected $showcase;

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
     * Getter for the year of creation
     *
     * @return int
     */
    public function getCryear()
    {
        return $this->cryear;
    }

    /**
     * Setter for the year of creation
     *
     * @param int $type
     * @return void
     * @api
     */
    public function setCryear($cryear)
    {
        $this->cryear = $cryear;
    }
	
	
    /**
     * Getter for the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Setter for the description
     *
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
     * Getter for the medium the artwork is created on
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkMedium> $medium
     *
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * Setter for the medium the artwork is created on
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtworkMedium> $medium
     * @return void
     */
    public function setMedium($medium)
    {
        $this->medium = $medium;
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