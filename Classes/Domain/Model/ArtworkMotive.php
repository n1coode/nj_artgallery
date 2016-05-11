<?php
namespace N1coode\NjArtgallery\Domain\Model;

/**
 * A type
 * @author n1coode
 * @package nj_artgallery
 */
class ArtworkMotive extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
	 * The description of the category.
	 *
	 * @var string
	 */
	protected $description = '';
	
	/**
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 255)
	 */
	protected $title;


	/* ***************************************************** */

	/**
	 * Constructs a new artwork type
	 *
	 */
	public function __construct() {

	}

	/* ***************************************************** */


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
	
	
	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title)
	{
		$this->title = $title;
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

} //end of class Tx_NjArtgallery_Domain_Model_ArtworkMotive
?>