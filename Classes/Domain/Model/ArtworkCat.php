<?php
namespace N1coode\NjArtgallery\Domain\Model;

/**
 * A category
 * @author n1coode
 * @package nj_artgallery
 */
class ArtworkCat extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	
	/**
	 * @var string
	 */
	protected $description;
	
	/**
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 255)
	 */
	protected $title;
	
	
	/* ***************************************************** */

	/**
	 * Constructs a new artwork category
	 *
	 */
	public function __construct() {

	}

	/* ***************************************************** */

	
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
	 * Getter for the description
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}
	
	
	/**
	 * @param string $title
	 * @return void
	 */
	public function seTitle($title)
	{
		$this->title = $title;
	}
	
	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}
	
} //end of class