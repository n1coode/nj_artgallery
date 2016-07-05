<?php
namespace N1coode\NjArtgallery\Controller;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class AjaxController extends \N1coode\NjArtgallery\Controller\AbstractController
{
	/**
	 * @var \N1coode\NjArtgallery\Domain\Repository\ArtworkRepository
	 * @inject
	 */
	protected $artworkRepository;
	
	
	/**
     * @var array
     */
    protected $arguments = array();

	
    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    protected function initializeAction()
    {
        $this->nj_domain_model = "Ajax";
		$this->nj_domain = strtolower($this->nj_domain_model);
		parent::init($this->nj_domain_model);
    }
	
	protected function enquiryAction() {
		$assignValues = [];
		$assignValues['ext'] = $this->getExtSettings();
		
		if($this->request->hasArgument('artwork'))
		{
			$assignValues['artwork'] = $this->artworkRepository->findByUid($this->request->getArgument('artwork'));
		}
		
		$this->view->assignMultiple($assignValues);
		return json_encode( 
            array(
                "success" => $success,
                "content" => $this->view->render()
			)
        );
	}
	
	protected function imageAction()
    {
		$success = true;
		
		$assignValues = [];
		$assignValues['test'] = $test;
		$assignValues['ext'] = parent::getExtSettings();
		
		if($this->request->hasArgument('artwork'))
		{
			$assignValues['artwork'] = $this->artworkRepository->findByUid($this->request->getArgument('artwork'));
		}
		
		
		$argument = 'collection';
		if($this->request->hasArgument($argument))
		{
			$collection = explode(",", $this->request->getArgument($argument));
			
			if(!empty($collection))
			{
				//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($collection,'collection');
				$i = 0;
				foreach($collection as $element)
				{
					//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArgument('artwork'),'artwork');
					if($element == $this->request->getArgument('artwork'))
					{
						$act = $i;
						break;
					}
					$i++;
				}
			}
			
			if($act !== NULL)
			{
				if($act > 0)
				{
					$i = $act - 1;
					$assignValues['prev'] = $this->artworkRepository->findByUid($collection[$i]);
				}
				if($act < count($collection) - 1)
				{
					$i = $act + 1;
					$assignValues['next'] = $this->artworkRepository->findByUid($collection[$i]);
				}
			}
			
			//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($assignValues);
		}
		
		
		
		if($this->request->hasArgument('uid'))
		{
			//$storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository'); // create instance to storage repository
			//$storage = $storageRepository->findByUid($this->request->getArgument('uid'));    // get file storage with uid 1 (this should by default point to your fileadmin/ directory)
			//$image = $storage->g;	
			
			
			
			//$assignValues['storage'] = $storage;
			//$fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
			//$image = $this->fileRepository->findByUid($this->request->getArgument('uid'));
		
			//$assignValues['image'] = $image;
		}

		$argument = 'model';
		if($this->request->hasArgument($argument))
		{
			switch($this->request->getArgument($argument))
			{
				case 'exhibition':
					break;
				default:;
			}
		}
		
		
		
		$assignValues['arguments'] = $this->request->getArguments();
		
		$this->view->assignMultiple($assignValues);
		
		return json_encode( 
            array(
                "success" => $success,
                "content" => $this->view->render()
			)
        );
	}
	
	protected function initArguments()
    {
        $this->arguments = $this->request->getArguments();
		
    }
}