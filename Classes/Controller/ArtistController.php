<?php
namespace N1coode\NjArtgallery\Controller;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class ArtistController extends \N1coode\NjArtgallery\Controller\AbstractController
{
	const _vtype_study = 'study';
	
	const _version_focus_complete = 'complete';
	const _version_focus_summary = 'summary';
	const _version_focus_artworks = 'artworks';
	const _version_focus_exhibitions = 'exhibitions';
	const _version_focus_vita = 'vita';
	
	/**
	 * @var \N1coode\NjArtgallery\Domain\Model\Artist 
	 */
	private $artist = NULL;
	
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
		$assignValues['ext'] = parent::getExtSettings();
		$assignValues['js'] = $this->getJsSettings();
		
		$action = explode("Action", __FUNCTION__)[0];
		$version = self::_version_focus_complete;
		if(array_key_exists('version', $this->settings['model'][$this->nj_domain][$action]))
		{
			$version = $this->settings['model'][$this->nj_domain][$action]['version'];
		}

		$assignValues['version'] = $version;
		
        $this->artist = new \N1coode\NjArtgallery\Domain\Model\Artist();
        if($artist !== NULL && is_object($artist)) {
			$this->artist = $artist;
            
			switch($version) {
				case self::_version_focus_summary:
					
					break;
				case self::_version_focus_artworks:
					$assignValues['artworks'] = $this->getArtworks();
					break;
				case self::_version_focus_vita:
					$this->addStudiesToArtist();
					break;
				default:
					//version:complete
					$this->addStudiesToArtist();
					$assignValues['artworks'] = $this->getArtworks();
			} //end of switch($version)
			$assignValues['artist'] = $this->artist;
        }
		else {
			$assignValues['errors']['noArtistFound'] = 1;
		}
		
		$this->view->assignMultiple($assignValues);
    }
	
	/**
	 * @param \N1coode\NjArtgallery\Domain\Model\Artist $artist The artist to be displayed
	 * @return void
	 */
	protected function menuAction(\N1coode\NjArtgallery\Domain\Model\Artist $artist = NULL)
	{
		
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
	
	/**
	 * @return array
	 */
	private function getArtworks()
	{
		$artworks = $this->artworkRepository->findByArtist($this->artist);
		
		if(is_object($artworks))
		{
			$assignArtworks = [];

			foreach($artworks as $artwork)
			{
				if($artwork->getImage() !== NULL)
				{
					$assignArtworks[] = $artwork;
				}
			}

			if(!empty($assignArtworks))
			{
				shuffle($assignArtworks);
				return $assignArtworks;
			}
		}
		return NULL;
	}
	
	private function addStudiesToArtist() {
		$vita = $this->artist->getVita();
		if(!empty($vita))
		{
			foreach($vita as $entry)
			{
				if($entry->getVtype() === self::_vtype_study)
				{
					$this->artist->pushStudies($entry);
				}
			}
		}
	}
}