<?php
namespace N1coode\NjArtgallery\Controller;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class ArtistController extends \N1coode\NjArtgallery\Controller\AbstractController
{
    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    protected function initializeAction()
    {
        $this->nj_domain_model = "Artist";
		$this->nj_domain = strtolower($this->nj_domain_model);
		parent::init($this->nj_domain_model);
    }
    
    
    /**
     * Displays a list of artists
     *
     * @return void
     */
    protected function listAction()
    {
		$action = explode("Action", __FUNCTION__)[0];
		$version = 'vertical';
		
		$assignValues = [];
		
		if(array_key_exists('version', $this->settings['model'][$this->nj_domain][$action]))
		{
			$version = $this->settings['model'][$this->nj_domain][$action]['version'];
		}
		
		$extSettings = parent::getExtSettings();
		$extSettings['version'] = $version;
		
		$assignValues['ext'] = $extSettings;
		
        $artists = $this->artistRepository->findByPermanent(1);
	
		
		if(is_object($artists))
		{
			$artists = $artists->toArray();
			
			if($this->request->hasArgument("artist"))
			{
				$selectedArtists = [];
				foreach($artists as $artist)
				{
					if($artist->getUid() != $this->request->getArgument("artist"))
					{
					   $selectedArtists[] = $artist;
					}
				}
				$artists = $selectedArtists;
			}

			$assignArtists = [];
			foreach($artists as $artist)
			{
				$artworks = $this->artworkRepository->findByArtist($artist);
				
				if(!empty($artworks))
				{
					$artworksArray = $artworks->toArray();
					
					shuffle($artworksArray);
					$artist->setTeaserArtwork($artworksArray[0]);
				}
				$assginArtists[] = $artist;
			}

			$assignValues['artists'] = $assginArtists;
			
		} //end of if(is_object}
		
		$this->view->assignMultiple($assignValues);
    }
    
    /**
     * Displays a single artist, depending to a given uid.
     *
     * @param \N1coode\NjArtgallery\Domain\Model\Artist $artist The artist to be displayed
     * @return void
     */
    protected function focusAction(\N1coode\NjArtgallery\Domain\Model\Artist $artist = NULL)
    {
		$assignValues = [];
		
        $selectedArtist = new \N1coode\NjArtgallery\Domain\Model\Artist();
        if($artist !== NULL)
        {
            if(is_object($artist))
            {
                $selectedArtist = $artist;
            }
            
			$assignValues['artist'] = $selectedArtist;
            $assignValues['ext'] = parent::getExtSettings();
			$assignValues['js'] = $this->jsSettings();
            
            $artworks = $this->artworkRepository->findByArtist($selectedArtist);
            if(is_object($artworks))
            {
                if($artworks !== NULL)
                {
                    $assignValues['artworks'] = $artworks;
                }
            }
        }
		$this->view->assignMultiple($assignValues);
    }
	
	/**
	 * Sets the settings especially needed for the ajax controller
	 */
	private function jsSettings()
	{
		$settings = [];
		
		$settings['lang']['id'] = $GLOBALS['TSFE']->sys_language_uid;
		$settings['lang']['iso'] = strtolower($GLOBALS['TSFE']->sys_language_isocode);

		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

		$settings['path']['partial'] = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPath']);
		$settings['path']['template'] = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);

		$settings['typeNum'] = $this->settings['general']['ajax']['typeNum'];
		$settings['pageId'] = $GLOBALS['TSFE']->page['uid'];
		
		return $settings;
	}
}
?>