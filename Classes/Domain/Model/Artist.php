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
	protected $enableEntireName;
	
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
	 * @var \N1coode\NjArtgallery\Domain\Model\Artwork
	 */
	protected $teaserArtwork;
	
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