<?php
namespace N1coode\NjArtgallery\Controller;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class ArtworkController extends \N1coode\NjArtgallery\Controller\AbstractController
{
	/**
	 * Initializes the controller before invoking an action method.
	 *
	 * @return void
	 */
	protected function initializeAction()
	{
		parent::init('Artwork');
	}
	
	
	/**
	 * Index action for this controller.
	 * @return void
	 */
	public function indexAction()
	{
	
	}
	
	
	/**
	 * Showcase action for this controller.
	 * @return void
	 */
	public function focusAction()
	{
	
	}
	
        
        /**
	 * List action for this controller.
	 *
	 * @return void
	 */
	public function listAction()
	{
		$assignValues = [];
		$assignValues['ext'] = parent::getExtSettings();
		
		$artworks = $this->artworkRepository->findAll();
		
		if(count($artworks) > 0)
		{
			$assignValues['artworks'] = $artworks;
		}
		
		$this->view->assignMultiple($assignValues);
	}
        
	
	/**
	 * QuoteRequest action for this controller.
	 * 
	 * @return void
	 */
	public function quoteRequestAction()
	{
		          
	}
	
	/**
	 * Showcase action for this controller.
	 *
	 * @return void
	 */
	public function showcaseAction()
	{
		$assignValues = [];
		$assignValues['ext'] = parent::getExtSettings();
		
		$randomArtwork = $this->artworkRepository->findRandom();
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($randomArtwork, '$randomArtwork');
                
		if($randomArtwork !== NULL)
		{
			$assignValues['artwork'] = $randomArtwork;
		}
				
		$this->view->assignMultiple($assignValues);
	}
	
	
} //end of N1coode\NjArtgallery\Controller\ArtworkController