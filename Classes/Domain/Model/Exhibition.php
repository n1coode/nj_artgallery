<?php
namespace N1coode\NjArtgallery\Domain\Model;

/**
 * An exhibition
 * @author n1coode
 * @package nj_artgallery
 */
class Exhibition extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
	 * @var string
	 */
	protected $title;
	
	/**
	 * @var string
	 */
	protected $description;
	
	/**
	 * @var DateTime
	 */
	protected $vernissageDate;
	
	/**
	 * @var DateTime
	 */
	protected $exhibitionStart;
	
	/**
	 * @var DateTime
	 */
	protected $exhibitionEnd;
	
	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
    protected $impressions;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
    protected $installation;
	
	/**
	 * @var int
	 */
	protected $type;
	
	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\Artist>
	 * @lazy
	 * @cascade remove
	 */
	protected $artists;
	
	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\Artwork>
	 * @lazy
	 * @cascade remove
	 */
	protected $artworks; 
	
	/* ***************************************************** */
	
	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $teaserImage;
	
	
	
	/**
	 * Constructs a new sheet
	 * @return AbstractObject
	 */
	public function __construct()
	{}
	
	/* ***************************************************** */
	
	
	/**
	 * Setter for the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	/**
	 * Getter for title
	 *
	 * @return \string
	 */
	public function getTitle()
	{
		return $this->title;
	}
	
	
	/**
	 * Setter for the description
	 *
	 * @param \string $description
	 * @return void
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}
	
	/**
	 * Getter for description
	 *
	 * @return \string
	 */
	public function getDescription()
	{
		return $this->description;
	}
	
	
	/**
	 * Setter for the date of the vernissage
	 *
	 * @param DateTime $vernissageDate
	 * @return void
	 * @api
	 */
	public function setVernissageDate(DateTime $vernissageDate)
	{
		$this->vernissageDate = $vernissageDate;
	}
	
	/**
	 * Getter for the date of the vernissage
	 *
	 * @return DateTime
	 */
	public function getVernissageDate()
	{
		return $this->vernissageDate;
	}
	
	
	/**
	 * Setter for the start date of the exhibition
	 *
	 * @param DateTime $exhibitionStart
	 * @return void
	 * @api
	 */
	public function setExhibitionStart(DateTime $exhibitionStart)
	{
		$this->exhibitionStart = $exhibitionStart;
	}
	
	/**
	 * Getter for the start date of the exhibition
	 *
	 * @return DateTime
	 */
	public function getExhibitionStart()
	{
		return $this->exhibitionStart;
	}
	
	
	/**
	 * Setter for the end date of the exhibition
	 *
	 * @param DateTime $exhibitionEnd
	 * @return void
	 * @api
	 */
	public function setExhibitionEnd(DateTime $exhibitionEnd)
	{
		$this->exhibitionEnd = $exhibitionEnd;
	}
	
	/**
	 * Getter for the end date of the exhibition
	 *
	 * @return DateTime
	 */
	public function getExhibitionEnd()
	{
		return $this->exhibitionEnd;
	}
	
	
	/**
	 * Returns the files
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $impressions
	 */
	public function getImpressions() 
	{
		return $this->impressions;		
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $impressions
	 * @return void
	 */
	public function setImpressions($impressions) 
	{
		$this->impressions = $impressions;
	}

	
	/**
	 * Returns the files
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $installation
	 */
	public function getInstallation() 
	{
		return $this->installation;		
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $installation
	 * @return void
	 */
	public function setInstallation($installation) 
	{
		$this->installation = $installation;
	}
	
	
	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getTeaserImage()
	{
		if($this->teaserImage === NULL)
		{
			$numberOfArtworks = count($this->artworks);
			if($numberOfArtworks > 0)
			{
				$random = rand(1,$numberOfArtworks);
				$i = 1;
				foreach($this->artworks as $artwork)
				{
					if($i === $random)
					{
						return $artwork->getImage();
					}
					$i++;
				}
				return NULL;
			}
		}
		else
		{
			return $this->teaserImage;
		}
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
	 * Sets the type
	 *
	 * @param int $type
	 * @return void
	 * @api
	 */
	public function setType($type)
	{
		$this->type = $type;
	}
	
	/**
	 * Returns the type
	 *
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * Returns the artists of this exhibition
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getArtists()
	{
		return $this->artists;
	}
	
	
	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\N1coode\NjArtgallery\Domain\Model\Artist> $artists
	 * @return void
	 */
	public function setArtists($artists)
	{
		$this->artists = $artists;
	}
	
	
	/**
	 * Returns the artworks of this exhibition
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getArtworks()
	{
		return $this->artworks;
	}
	
} //end of class N1coode\NjArtgallery\Domain\Model\Exhibition
?>