<?php
namespace N1coode\NjArtgallery\Domain\Model;

/**
 * An university
 * @author n1coode
 * @package nj_artgallery
 */
class Uni extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $nameShort;
    
   
    /* ***************************************************** */

    /**
     * Constructs a new artist
     * @return AbstractObject
     */
    public function __construct() {

    }

    /* ***************************************************** */
    
    
    /**
     * Getter for the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    
    /**
     * Getter for the short name
     *
     * @return string
     */
    public function getNameShort()
    {
        return $this->nameShort;
    }
    
    /**
     * Setter for the short name
     *
     * @param string $nameShort
     * @return void
     */
    public function setNameShort($nameShort)
    {
        $this->nameShort = $nameShort;
    }
	
} //end of class Tx_NjArtgallery_Domain_Model_Artist
?>

