<?php
namespace N1coode\NjArtgallery\Domain\Model;

/**
 * An artist
 * @author n1coode
 * @package nj_artgallery
 */
class Artist extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected $advertise;
    
	/**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtistCat>
     * @lazy
     * @cascade remove
     */
    protected $categories;
	
	/**
	 * @var string
	 */
	protected $city;
	
	/**
	 * @var string 
	 */
	protected $country;
	
	/**
	 * @var int
	 */
	protected $enableEntireName;
	
    /**
     * @var int
     */
    protected $finishedTraining;
    
	/**
     * @var string
     */
    protected $firstName;
	
	/**
	 * @var int 
	 */
	protected $gender;
	
	/**
     * @var string
     */
    protected $lastName;
	
    /**
     * @var string
     */
    protected $name;
    
	/**
	 * @var int
	 */
	protected $permanent;

	/**
     * @var string
     */
    protected $summary;
 
	/**
	 * @var array 
	 */
	protected $studies = NULL;
	
	/**
	 * @var \N1coode\NjArtgallery\Domain\Model\Artwork
	 */
	protected $teaserArtwork;
	
	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $teaserImage;
	
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\Uni>
     * @lazy
     * @cascade remove
     */
    protected $universities;
	
	/**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtistVita>
     * @lazy
     * @cascade remove
     */
    protected $vita;
	
	
    /* ***************************************************** */

    /**
     * Constructs a new artist
     * @return AbstractObject
     */
    public function __construct() {

    }

    /* ***************************************************** */


    /**
     * Getter for the advertising option
     *
     * @return int
     */
    public function getAdvertise()
    {
        return $this->advertise;
    }

    /**
     * Setter for the advertising option
     *
     * @param int $advertise
     * @return void
     * @api
     */
    public function setAdvertise($advertise)
    {
        $this->advertise = $advertise;
    }
    
	
	/**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtistCat>
     */
    public function getCategories()
    {
        return $this->categories;
    }
	
	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtistCat> $categories
	 * @return void
	 */
	public function setCategories($categories)
	{
		$this->categories = $categories;
	}
	
	
    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }
	
	
	/**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * @param string $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
	
	
	/**
     * @return int
     */
    public function getEnableEntireName()
    {
        return $this->enableEntireName;
    }

    /**
     * @param int $enableEntireName
     * @return void
     * @api
     */
    public function setEnableEntireName($enableEntireName)
    {
        $this->enableEntireName = $enableEntireName;
    }
	
	
    /**
     * Getter for the option finished training
     *
     * @return int
     */
    public function getFinishedTraining()
    {
        return $this->finishedTraining;
    }

    /**
     * Setter for the option finished training
     *
     * @param int $finishedTraining
     * @return void
     * @api
     */
    public function setFinishedTraining($finishedTraining)
    {
        $this->finishedTraining = $finishedTraining;
    }
    
	
	/**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * @param string $firstName
     * @return void
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
	
	
	/**
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     * @return void
     * @api
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }
	
	
	/**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * @param string $lastName
     * @return void
     */
    public function setLastName($lastName)
    {
        $this->lasttName = $lastName;
    }
	
    
    /**
     * Getter for the name
     *
     * @return string
     */
    public function getName()
    {
		$this->setName();
		return $this->name;
    }
    
    /**
     * Sets the name
     *
     * @return void
     */
    public function setName()
    {
        if($this->enableEntireName)
		{
			$this->name = $this->firstName . ' ';
		}
		$this->name .= $this->lastName;
    }

    
    /**
     * Getter for the summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }
	
    /**
     * Sets the summary
     *
     * @param string $summary
     * @return void
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

	
	/**
	 * @return \N1coode\NjArtgallery\Domain\Model\Artwork
	 */
	public function getTeaserArtwork()
	{
		return $this->teaserArtwork;
	}
	
	/**
     * Sets the summary
     *
     * @param \N1coode\NjArtgallery\Domain\Model\Artwork $teaserArtwork
     * @return void
     */
    public function setTeaserArtwork($teaserArtwork)
    {
        $this->teaserArtwork = $teaserArtwork;
    }
	
	
	/**
     * @return int
     */
    public function getPermanent()
    {
        return $this->permanent;
    }
	
	/**
     * @param int $permanent
     * @return void
     */
    public function setPermanent($permanent)
    {
        $this->permanent = $permanent;
    }
	
	
	/**
     * @return array
     */
    public function getStudies()
    {
		return $this->studies;
    }
	
	/**
	 * @param \N1coode\NjArtgallery\Domain\Model\ArtistVita $vita
	 */
	public function pushStudies($vita)
	{
		if($this->studies === NULL)
		{
			$this->studies = [];
		}
		$this->studies[] = $vita;
	}
	
    /**
	 * @param array $studies
     * @return void
     */
    public function setStudies($studies)
    {
        $this->studies = $studies;
    }
	
	
	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getTeaserImage()
	{
		return $this->teaserImage;
	}
	
	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserImage
	 * @return void
	 */
	public function setTeaserImage($teaserImage)
	{
		$this->teaserImage = $teaserImage;
	}
	
	
    /**
     * Getter for the universities the artist has finished
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\Uni> $universities
     *
     */
    public function getUniversities()
    {
        return $this->universities;
    }
	
	 /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\ArtistVita> $vita
     *
     */
    public function getVita()
    {
        return $this->vita;
    }
	
} //end of class Tx_NjArtgallery_Domain_Model_Artist
?>