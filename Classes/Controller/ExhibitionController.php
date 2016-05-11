<?php
namespace N1coode\NjArtgallery\Controller;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class ExhibitionController extends \N1coode\NjArtgallery\Controller\AbstractController
{	
	
	
	/**
	 * Initializes the controller before invoking an action method.
	 *
	 * @return void
	 */
	protected function initializeAction()
	{
		$this->nj_domain_model = "Exhibition";
		$this->nj_domain = strtolower($this->nj_domain_model);
		parent::init($this->nj_domain_model);
	}

	
	/**
	 * Index action for this controller. Displays the exhibition according to a given StoragePid.
	 *
	 * @return void
	 */
	public function indexAction()
	{
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->sliderRepository);
		//$slider = $this->sliderRepository->findByUid($this->settings['model']['slider']['uid']);
		//$this->view->assign('settings', $this->settings['model']['slider']);
		//$this->view->assign('slider', $slider);
	}
	
	
	/**
	 * Actual (exhibition) action for this controller.
	 *
	 * @return void
	 */
	public function actualAction()
	{
		$action = explode("Action", __FUNCTION__)[0];
		
		$assignValues = [];
		
		$extSettings = parent::getExtSettings();

		if(array_key_exists('version', $this->settings['model'][$this->nj_domain][$action]))
		{
			$extSettings['version'] = $this->settings['model'][$this->nj_domain][$action]['version'];
		}

		$assignValues['ext'] = $extSettings;
		
		$assignValues['exhibition'] = $this->exhibitionRepository->findActualExhibition();
		
		$this->view->assignMultiple($assignValues);
		$assignValues['js'] = $this->getJsSettings();
		
		$this->view->assignMultiple($assignValues);
	}
	
	
	/**
	 * Actual teaser action for this controller.
	 *
	 * @return void
	 */
	public function actualTeaserAction()
	{
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->view);
		$action = explode("Action", __FUNCTION__)[0];
		
		$assignValues = [];
		$assignValues['ext'] = parent::getExtSettings();
		
		$assignValues['exhibition'] = $this->exhibitionRepository->findActualExhibition();
 		
		
		$this->view->assignMultiple($assignValues);
	}
	
        
	/**
	 * Displays a list of exhibitions
	 * @return void
	 */
	public function listAction()
	{
		$action = explode("Action", __FUNCTION__)[0];
		$version = 'standard';
		
		$assignValues = [];

		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->settings,'settings');
		if(array_key_exists('version', $this->settings['model'][$this->nj_domain][$action]))
		{
			$version = $this->settings['model'][$this->nj_domain][$action]['version'];
		}
		
		$extSettings = parent::getExtSettings();
		$extSettings['version'] = $version;
		
		$assignValues['ext'] =$extSettings;
		
		switch ($version) {
			case 'standard':
				$exhibitions = $this->exhibitionRepository->findNextVernissages();
				break;
			case 'next':
				$exhibitions = $this->exhibitionRepository->findNextVernissages();
				break;
			case 'past':
				$exhibitionsRaw = $this->exhibitionRepository->findPastExhibitions(16)->toArray();
				
				$exhibitions = [];
				foreach($exhibitionsRaw as $exhibition)
				{
					$artists = $exhibition->getArtists()->toArray();
					$filteredArtists = [];
					foreach($artists as $artist)
					{
						if($artist->getPermanent()  === 1)
						{
							$filteredArtists[] = $artist;
						}
					}
					
					shuffle($filteredArtists);
					$exhibition->setArtists($filteredArtists);
					$exhibitions[] = $exhibition;
				}
				
			default:
				break;
		}
		
		if(is_object($exhibitions) || is_array($exhibitions))
		{
			$assignValues['exhibitions'] = $exhibitions;
		}

		$this->view->assignMultiple($assignValues);
	}
        
	
	private function filterExhibitions($exhibitionsRaw = NULL)
	{
		$exhibitions = [];
		
		if($exhibitionsRaw !== NULL && count($exhibitionsRaw) > 0)
		{
			foreach($exhibitionsRaw as $exhibition)
			{
				$exhibitions[] = filterExhibition($exhibition);
			}
		}
		
		return $exhibitions;
	}
	
	/**
	 * @param \N1coode\NjArtgallery\Domain\Model\Exhibition $exhibitionRaw
	 * @return \N1coode\NjArtgallery\Domain\Model\Exhibition $exhibition
	 */
	private function filterExhibition($exhibitionRaw = NULL)
	{
		$exhibition = new \N1coode\NjArtgallery\Domain\Model\Exhibition();
		
		if(is_object($exhibitionRaw))
		{
			$artists = $exhibitionRaw->getArtists()->toArray();
			$filteredArtists = [];
			
			foreach($artists as $artist)
			{
				if($artist->getPermanent()  === 1)
				{
					$filteredArtists[] = $artist;
				}
			}
			shuffle($filteredArtists);
			$exhibitionRaw->setArtists($filteredArtists);
			$exhibition = $exhibitionRaw;
		}
		return $exhibition;
	}
	
	/**
	 * Displays a tiny list of exhibitions
	 * @return void
	 */
	public function tinyListAction()
	{
		
	}
	
        
	/**
	 * Displays a single exhibition, depending to a given uid.
	 *
	 * @param \N1coode\NjArtgallery\Domain\Model\Exhibition $exhibition The exhibition to display
	 * @return void
	 */
	public function focusAction(\N1coode\NjArtgallery\Domain\Model\Exhibition $exhibition)
	{
		$assignValues = [];
		$extSettings = parent::getExtSettings();
		$assignValues['ext'] =$extSettings;
		$assignValues['js'] = $this->getJsSettings();
		
		$pastExhibitions = $this->exhibitionRepository->findPastExhibitions();
		$filterExhibition = false;
		foreach($pastExhibitions as $pastExhibition)
		{
			if($exhibition === $pastExhibition)
			{
				$filterExhibition = true;
				break;
			}
		}
		
		
		if($filterExhibition)
		{
			$assignValues['exhibition'] = $this->filterExhibition($exhibition);
			$assignValues['filteredArtists'] = 1;
		}
		else
		{
			$assignValues['exhibition'] = $exhibition;
		}

		$this->view->assignMultiple($assignValues);
	}
	
} //end of class N1coode\NjArtgallery\Controller\ExhibitionController