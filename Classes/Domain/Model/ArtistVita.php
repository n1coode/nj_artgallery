<?php
namespace N1coode\NjArtgallery\Domain\Model;

/**
 * A category
 * @author n1coode
 * @package nj_artgallery
 */
class ArtistVita extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
	 * @var string
	 */
	protected $dateFrom;
	
	/**
	 * @var string
	 */
	protected $dateTo;
	
	/**
	 * @var string
	 */
	protected $content;
	
	
	/* ***************************************************** */

	/**
	 * Constructs a new Artist vita entry
	 *
	 */
	public function __construct() {

	}

	/* ***************************************************** */

	
	/**
	 * @param string $dateFrom
	 * @return void
	 */
	public function setDateFrom($dateFrom)
	{
		$this->dateFrom = $dateFrom;
	}
	
	/**
	 * @return string
	 */
	public function getDateFrom()
	{
		return $this->dateFrom;
	}
	
	
	/**
	 * @param string $dateTo
	 * @return void
	 */
	public function setDateTo($dateTo)
	{
		$this->dateTo = $dateTo;
	}
	
	/**
	 * @return string
	 */
	public function getDateTo()
	{
		return $this->dateTo;
	}
	
	
	/**
	 * @param string $content
	 * @return void
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}
	
	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}
	
} //end of class