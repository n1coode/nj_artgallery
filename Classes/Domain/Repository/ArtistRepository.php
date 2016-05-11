<?php
namespace N1coode\NjArtgallery\Domain\Repository;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class ArtistRepository extends \N1coode\NjArtgallery\Domain\Repository\AbstractRepository
{
	protected $defaultOrderings = array(
            'last_name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
	);
	
} //end of class Tx_NjArtgallery_Domain_Repository_ArtistRepository
?>