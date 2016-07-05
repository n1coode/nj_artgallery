?php
namespace N1coode\NjArtgallery\Controller;
/**
 * Abstract base controller for the extension Tx_NjArtgallery
 * @author n1coode
 * @package nj_artgallery
 */
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	/**
	 * @var string
	 */
	protected $nj_ext_key = \N1coode\NjArtgallery\Utility\Constants::NJ_EXT_KEY;
	
	/**
	 * @var string
	 */
	protected $nj_ext_path = \N1coode\NjArtgallery\Utility\Constants::NJ_EXT_PATH;
	
	/**
	 * @var string
	 */
	protected $nj_ext_namespace = \N1coode\NjArtgallery\Utility\Constants::NJ_EXT_NAMESPACE;

	/**
	 * @var string
	 */
	protected $nj_domain_model = '';
	
	/**
	 * @var string
	 */
	protected  $nj_domain = '';
	
	/**
	 * @var array
	 */
	protected $nj_settings = array();
	
	
	/**
	 * @var Integer
	 */
	protected $storagePid;

	/**
	 * @var string
	 */
	protected $extRelPath = 'nj_artgallery';
	
        
	/**
	 * @var \N1coode\NjArtgallery\Domain\Repository\ArtistRepository
	 * @inject
	 */
	protected $artistRepository;
	
	/**
	 * @var \N1coode\NjArtgallery\Domain\Repository\ArtworkRepository
	 * @inject
	 */
	protected $artworkRepository;
	
	/**
	 * @var \N1coode\NjArtgallery\Domain\Repository\ArtworkCatRepository
	 * @inject
	 */
	protected $artworkCatRepository;
	
	/**
	 * @var \N1coode\NjArtgallery\Domain\Repository\ArtworkMediumRepository
	 * @inject
	 */
	protected $artworkMediumRepository;
	
	/**
	 * @var \N1coode\NjArtgallery\Domain\Repository\ArtworkTechRepository
	 * @inject
	 */
	protected $artworkTechRepository;
	
	/**
	 * @var \N1coode\NjArtgallery\Domain\Repository\ExhibitionRepository
	 * @inject
	 */
	protected $exhibitionRepository;
	
	/**
	 * @var \N1coode\NjArtgallery\Domain\Repository\UniRepository
	 * @inject
	 */
	protected $uniRepository;

	/**
	 * @var \TYPO3\CMS\Core\Resource\FileRepository
	 * @inject
	 */
	protected $fileRepository;
	
	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;
	
	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;
	
	
	/**
	 * 
	 * @param string $model
	 * @throws Exception
	 */
	protected function init($model)
	{	
		if($model !== null)
		{
			$this->nj_domain_model = $model;
			$this->nj_domain = strtolower($this->nj_domain_model);
			
			$this->configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
			
			if(\N1coode\NjCollection\Utility\Configuration::flexformSettingsExists($this->configurationManager))
			{
				\N1coode\NjCollection\Utility\Configuration::settings($this->configurationManager);
			}
			
			$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
			
			$this->settings = $configuration['settings'];
                        
			unset($this->settings['flexform']);
			
		} //end of if model
		else
		{
			throw new \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
				('Kein Model angegeben. Überprüfe die Controller-Klasse.',48246892768209576);
		}
		
		if(!isset($this->settings))
			throw new \TYPO3\CMS\Extbase\Configuration\Exception('Please include typoscript to enable the extension.', 48246892768209576 );
		
		if(isset($configuration['persistence']['storagePid']))
			$this->storagePid = intval($configuration['persistence']['storagePid']);		
		
		$this->includeCss();
		$this->includeJavaScript();
	} 
	
	
	protected function callActionMethod() 
	{
		Try {
			parent::callActionMethod();
		} Catch(Exception $e) {
			$this->response->appendContent($e->getMessage());
		}
	}
	

	/**
	 * @param \String $controller
	 * @param \String $action
	 * @param \String $format
	 * @return \TYPO3\CMS\Fluid\View\StandaloneView
	 */
	protected function initViewAjax($controller, $action, $format)
	{
		$view = $this->objectManager->create('TYPO3\CMS\Fluid\View\StandaloneView');
		$view->setFormat($format);
		$view->setTemplatePathAndFilename(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:nj_artgallery/Resources/Private/Templates/'.$controller.'/'.ucfirst($action).'.'.$format));
		$view->setPartialRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:nj_artgallery/Resources/Private/Partials/'));
		$view->setLayoutRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:nj_artgallery/Resources/Private/Layouts/'));
		
		return $view;
	}
	
	private function includeCss()
	{
		$this->getPageRenderer()
			->addCssFile(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nj_artgallery') . 'Resources/Public/Css/flaticons/articon.css');
	}
	
	private function includeJavaScript()
	{
		//$this->getPageRenderer()
		//	->addJsFooterFile(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nj_artgallery') . 'Resources/Public/Javascript/tx_njartgallery_frontend.js');
	}
	
	
	/**
	 * Sets the settings especially needed for the ajax controller
	 */
	protected function getJsSettings()
	{
		$jsSettings = [];
		$jsSettings['variableName'] = '_'.$this->nj_ext_key.'_'.$this->nj_domain.'_'.explode('Action',self::getCaller())[0];
		$jsSettings['container'] = '.'.$this->nj_ext_key.'.'.$this->nj_domain.'.'.explode('Action',self::getCaller())[0];
		
		
		$jsSettings['lang']['id'] = $GLOBALS['TSFE']->sys_language_uid;
		$jsSettings['lang']['iso'] = strtolower($GLOBALS['TSFE']->sys_language_isocode);

		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

		$jsSettings['path']['partial'] = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPath']);
		$jsSettings['path']['template'] = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);

		$jsSettings['typeNum'] = $this->settings['general']['ajax']['typeNum'];
		$jsSettings['pageId'] = $GLOBALS['TSFE']->page['uid'];
		
		return $jsSettings;
	}
	
	protected function getExtSettings()
	{
		$extSettings = [];
		$extSettings['key']			= $this->nj_ext_key;
		$extSettings['name']		= strtolower($this->nj_ext_namespace);
		$extSettings['controller']	= $this->nj_domain_model;		
		$extSettings['domain']		= $this->nj_domain;
		$extSettings['action']		= explode('Action',self::getCaller())[0];
		$extSettings['langFile']	= 'LLL:EXT:'.$this->nj_ext_path.'/Resources/Private/Language/locallang.xlf:';
		$extSettings['language']	= $GLOBALS['TSFE']->sys_language_uid;
		
		return $extSettings;
	}
	
	protected function getConfiguration()
	{
		$this->configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
		return  $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK); 
	}

	protected function getCaller() 
	{
		$trace = debug_backtrace();
		$name = $trace[2]['function'];
		return empty($name) ? 'global' : $name;
	}
	
	
	protected function storagePidIsset()
	{
		if(isset($this->settings['persistence']['storagePid']))
		{
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Provides a shared (singleton) instance of PageRenderer
	 *
	 * @return \TYPO3\CMS\Core\Page\PageRenderer
	 */
	protected function getPageRenderer() {
		return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
	}

} //end of class N1coode\NjArtgallery\Controller\AbstractController
?>