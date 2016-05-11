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
	protected $name;
	
	
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
	 * Setter for the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Getter for the name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
} //end of class Tx_NjArtgallery_Domain_Model_ArtworkCat
?>