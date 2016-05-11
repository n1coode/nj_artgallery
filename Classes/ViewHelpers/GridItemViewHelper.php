<?php
namespace N1coode\NjArtgallery\ViewHelpers;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class GridItemViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
	/**
	 * @var string 
	 */
	var $retval;
	
	/**
	 * @var boolean
	 */
	var $setLink = false;
	
	/**
	 * @var array
	 */
	var $args;
	
	/**
	 * @param string $type
	 * @param array $args
	 * @return string
	 */
	public function render($type = NULL, $args = NULL)
    {
		$this->retval = '<div class="grid-item">';
		
		if($args !== NULL)
		{
			$this->args = $args;
		
			if(array_key_exists('artist', $this->args))
			{
				
				
				$artist = new \N1coode\NjArtgallery\Domain\Model\Artist();
				$artist = $args['artist'];
				
				if($artist->getAdvertise())
				{
					$focus = $this->getFocus('artist');
					if($focus > 0)
					{
						
					}
				}
				
			}
		}
		
		$class = NULL;
		
		
		$this->retval .= $this->renderChildren();
		$this->retval .= '</div>';
		
		return $this->retval;
	}
	
	/**
	 * @param string $type
	 * @return int
	 */
	public function getFocus($type=NULL)
	{
		if($this->args !== NULL && $type !== NULL)
		{
			if(array_key_exists('settings', $this->args))
			{
				if(isset($this->args['settings']['model'][$type]['pid']['focus']))
				{
					return $this->args['settings']['model'][$type]['pid']['focus'];
				}
			}
		}
		return -1;
	}
}