<?php
namespace N1coode\NjArtgallery\Domain\Model;

/**
 * A category
 * @author n1coode
 * @package nj_artgallery
 */
class ArtistCat extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 255)
	 */
	protected $title;
	
	/**
	 * The description of the category.
	 *
	 * @var string
	 */
	protected $description = '';
	
	
	/* ***************************************************** */

	/**
	 * Constructs a new work
	 *
	 */
	public function __construct() {

	}

	/* ***************************************************** */

	
	/**
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title)
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
	
	
	/**
	 * Sets the description
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
	
} //end of class