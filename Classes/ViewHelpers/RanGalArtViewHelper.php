<?php
namespace N1coode\NjArtgallery\ViewHelpers;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class RanGalArtViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
	/**
	 * @var array
	 */
	protected $images = [];
	
	/**
	 * @var array
	 */
	protected $imagesTmp = [];
	
	
	/**
	 *	Discription
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $artworks
	 * @return array $images
	 */
	public function render(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $artworks = null)
	{		
		if($artworks != null)
		{
			
			foreach($artworks as $artwork)
			{
				$this->imagesTmp[] = $artwork->getImage();
			}
		
			$numberOfImages = count($this->imagesTmp);
			
			if($numberOfImages >= 3)
			{
				$random = [];
				
				$x = 0;
				while ($x < 3) 
				{
					$randNumber = rand (0, ($numberOfImages - 1) );
					if(!in_array($randNumber, $random))
					{
						$random[] = $randNumber;
						$x++;
					}
				}
				
				foreach($random as $index)
				{
					$this->images[] = $this->imagesTmp[$index];
				}
				
				
			} //end of if($numberOfImages > 3)
			else
			{
				$this->images = $this->imagesTmp;
			}
		
		
		} //end of if ($artworks != null)
		return $this->images;
	} 
	
} //end of class Tx_NjArtgallery_ViewHelpers_RanGalArtViewHelper
?>