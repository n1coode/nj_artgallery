<?php
namespace N1coode\NjArtgallery\Domain\Repository;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class ArtworkCatRepository extends \N1coode\NjArtgallery\Domain\Repository\AbstractRepository
{
	protected $defaultOrderings = array(
		'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
	);
	
} //end of class Tx_NjArtgallery_Domain_Repository_ArtistRepository
?>