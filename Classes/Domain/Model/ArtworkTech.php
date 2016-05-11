<?php
namespace N1coode\NjArtgallery\Domain\Model;

/**
 * A technique
 * @author n1coode
 * @package nj_artgallery
 */
class ArtworkTech extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
	 * @var \string
	 * @validate StringLength(minimum = 3, maximum = 255)
	 */
	protected $name;
	
	/**
	 * The description of the category.
	 *
	 * @var \string
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
	 * Sets the name
	 *
	 * @param \string $name
	 * @return void
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Getter for the name
	 *
	 * @return \string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	
	/**
	 * Sets the description
	 *
	 * @param \string $description
	 * @return void
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}
	
	/**
	 * Getter for the description
	 *
	 * @return \string
	 */
	public function getDescription()
	{
		return $this->description;
	}
	
} //end of class Tx_NjArtgallery_Domain_Model_ArtworkCat
?>