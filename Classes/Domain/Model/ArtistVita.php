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
	protected $content;
	
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
	protected $degree;

	/**
	 * @var string 
	 */
	protected $vtype;
	
	/**
	 * @var \N1coode\NjArtgallery\Domain\Model\Uni 
	 */
	protected $uni;
	
	
	/* ***************************************************** */

	/**
	 * Constructs a new Artist vita entry
	 *
	 */
	public function __construct() {

	}

	/* ***************************************************** */

	
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
	 * @param string $degree
	 * @return void
	 */
	public function setDegree($degree)
	{
		$this->degree = $degree;
	}
	
	/**
	 * @return string
	 */
	public function getDegree()
	{
		return $this->degree;
	}
	
	
	/**
	 * @return string
	 */
	public function getVtype()
	{
		return $this->vtype;
	}
	
	/**
	 * @param string $vtype
	 * @return void
	 */
	public function setVtype($vtype)
	{
		$this->vtype = $vtype;
	}
	
	
	/**
	 * @return \N1coode\NjArtgallery\Domain\Model\Uni
	 */
	public function getUni()
	{
		return $this->uni;
	}
	
	/**
	 * @param \N1coode\NjArtgallery\Domain\Model\Uni $uni
	 * @return void
	 */
	public function setUni($uni)
	{
		$this->uni = $uni;
	}
	
	
} //end of class