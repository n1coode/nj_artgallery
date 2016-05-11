<?php
namespace N1coode\NjArtgallery\Controller;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
/**
 * @author n1coode
 * @package nj_artgallery
 */
class HeaderController extends \N1coode\NjArtgallery\Controller\AbstractController
{
	/**
	 * Initializes the controller before invoking an action method.
	 *
	 * @return void
	 */
	protected function initializeAction()
	{
		$this->nj_domain_model = "Header";
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
		/*
		 * next Vernissage
		 */
		$nextVernissage = $this->exhibitionRepository->findNextVernissage();
 		//DebuggerUtility::var_dump($nextVernissage, 'nextVernissage');
		
 		$theVernissage = new \N1coode\NjArtgallery\Domain\Model\Exhibition();
  		if(isset($nextVernissage[0]))
  		{
  			$theVernissage = $nextVernissage[0];
  		}
 		$this->view->assign('nextVernissage', $theVernissage); //im fluid abfangen 
		
 		/*
 		 * actual Exhibition
 		 */
 		$actualExhibition = $this->exhibitionRepository->findActualExhibition(38);
 		//DebuggerUtility::var_dump($actualExhibition, 'actualExhibition');
 		
 		$theExhibition = new \N1coode\NjArtgallery\Domain\Model\Exhibition();
 		if(isset($actualExhibition[0]))
 		{
 			$theExhibition = $actualExhibition[0];
 		}
 		$this->view->assign('actualExhibition', $theExhibition); //im fluid abfangen
	}
	
	
	public function startpageAction()
	{
		$action = explode("Action", __FUNCTION__)[0];
		$version = '';
		
		$assignValues = [];
		
		$extSettings = parent::getExtSettings();
		$assignValues['ext'] = $extSettings;
		
		$this->view->assignMultiple($assignValues);
	}
	
	public function standardAction()
	{
		
	}
	
	public function contactAction()
	{
		
	}
	
	public function artistAction()
	{
		
	}
	
	public function exhibitionsAction()
	{
		$action = explode("Action", __FUNCTION__)[0];
		$version = '';
		
		$assignValues = [];
		
		$extSettings = parent::getExtSettings();
		$assignValues['ext'] = $extSettings;
		
		
		$actualExhibition = $this->exhibitionRepository->findActualExhibition();
		
		$assignValues['exhibition'] = $actualExhibition;
		$this->view->assignMultiple($assignValues);
	}
	
} //end of class N1coode\NjArtgallery\Controller\HeaderController
?>