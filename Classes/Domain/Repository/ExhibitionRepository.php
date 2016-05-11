<?php
namespace N1coode\NjArtgallery\Domain\Repository;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class ExhibitionRepository extends \N1coode\NjArtgallery\Domain\Repository\AbstractRepository
{
 	protected $defaultOrderings = array(
 		'vernissage_date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
 	);
	
	
	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface The vernissage
	 */
	public function findNextVernissage($storagePid = 38)
	{
            $query = $this->createQuery();
            $query->statement(
                "SELECT
                 *
                 FROM tx_njartgallery_domain_model_exhibition
                 WHERE FROM_UNIXTIME(vernissage_date,'%Y%m%d') >= DATE_FORMAT(CURDATE(),'%Y%m%d')
                 AND deleted = 0 AND hidden = 0
                 AND pid = ".$storagePid."
                 ORDER BY vernissage_date ASC
                 LIMIT 0,1"
            );
            return $query->execute(FALSE);
	}
	
	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface The vernissages
	 */
	public function findNextVernissages($limit = 5)
	{
		$query = $this->createQuery();

		/**
		$query->statement(
			"SELECT
			 *
			 FROM tx_njartgallery_domain_model_exhibition
			 WHERE FROM_UNIXTIME(vernissage_date,'%Y%m%d') >= DATE_FORMAT(CURDATE(),'%Y%m%d')
			 AND deleted = 0 AND hidden = 0
			 AND pid = ".$storagePid."
			 ORDER BY vernissage_date ASC"
		);
		return $query->execute(FALSE);
		 */

		$query->matching(
			$query->logicalAnd(
				$query->greaterThanOrEqual('vernissage_date', date('U'))
			)
		);
		$query->setOffset(0);
		$query->setLimit($limit);
		return $query->execute();
	}
      
	/**
	 * @param int $limit
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface The exhibitions
	 */
	public function findPastExhibitions($limit = 5)
	{
		$actExhibition = $this->findActualExhibition();
		$actDate = $actExhibition->getVernissageDate();
		
		
		$this->defaultOrderings = array(
			'vernissage_date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
		);
		
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				$query->lessThan('vernissage_date', $actDate)
			)
		);
		$query->setOffset(0);
		$query->setLimit($limit);
		return $query->execute();
	}
	
	/**
	 * @param int $storagePid
	 * @return \N1coode\NjArtgallery\Domain\Model\Exhibition The exhibition
	 */
	public function findActualExhibition($storagePid = 38)
	{
		$query = $this->createQuery();
		$query->statement(
			"SELECT
			 *
			 FROM tx_njartgallery_domain_model_exhibition
			 WHERE FROM_UNIXTIME(exhibition_start,'%Y%m%d') <= DATE_FORMAT(CURDATE() + INTERVAL 1 DAY,'%Y%m%d')
			 AND deleted = 0 AND hidden = 0
			 AND pid = ".$storagePid."
  			 ORDER BY exhibition_start DESC
			 LIMIT 0,1"
		);
		
		return $query->execute(FALSE)->getFirst();
	} 
	
} //end of class \N1coode\NjArtgallery\Domain\Repository\ExhibitionRepository
?>