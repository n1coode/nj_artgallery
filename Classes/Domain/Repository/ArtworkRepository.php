<?php
namespace N1coode\NjArtgallery\Domain\Repository;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class ArtworkRepository extends \N1coode\NjArtgallery\Domain\Repository\AbstractRepository
{
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    /**
     * Get a random object
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array The random artwork
     */
    public function findRandom() 
    {
        $query = $this->createQuery();
        $query->matching($query->equals('showcase', 1));
        $results = $query->execute();

		
		
		if(is_object($results))
		{
			$results = $results->toArray();
		}
		
		$filteredResults = [];
		
		foreach($results as $result)
		{
			$artist = $result->getArtist();
			
			if($artist->getPermanent() == 1 && $artist->getAdvertise() == 1)
			{
				$filteredResults[] = $result;
			}
		}
		
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($filteredResults);
		
		$count = count($filteredResults);
        if($count > 0)
        {
            if($count === 1)
            {
                return $filteredResults[0];
            }
            else 
            {
                $x = mt_rand(0, max(0, ($count - 1)));
                return $filteredResults[$x];
            }
        }
        else
        {
            return NULL;
        }
    }
	
} //end of class Tx_NjArtgallery_Domain_Repository_ArtworkRepository
?>