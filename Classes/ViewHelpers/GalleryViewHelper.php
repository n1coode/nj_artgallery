<?php
namespace N1coode\NjArtgallery\ViewHelpers;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class GalleryViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
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
    public function render(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $artworks = NULL)
    {	
        $this->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
        $galleryFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('nj_artgallery').'Resources/Public/Gfx/gallery.png';
    
        $galleryFileExists = file_exists($galleryFile)?true:false;

        if($galleryFileExists)
        {
            $imageProperties = array();
            $imageProperties['url']     = $galleryFile;
            $imageProperties['width']   = getimagesize($galleryFile)[0];
            $imageProperties['height']  = getimagesize($galleryFile)[1];
            $imageProperties['mime']    = getimagesize($galleryFile)['mime'];

            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($imageProperties,'GalleryViewHelper -> $imageProperties');
            
            $XY = $imageProperties['width'].','.$imageProperties['height'];
            
            $conf = array(
                'file' => 'GIFBUILDER',
		'file.' => array(
                    'XY' => $XY,
                    'format' => 'png',
                    'quality' => 100,
                    'backColor' => '#cccccc',
                    'transparentBackground' => 1,
                    'transparentColor' => '#ffffff',
                    'transparentColor.closest' => 1,
                    
                    '10' => 'IMAGE',
                    '10.' => array(
                        'offset' => '0,0',
                        'file' => $imageProperties['url'],
                        'file.' => array(
                            'width' => $imageProperties['width'],
                            'height' => $imageProperties['height'],
                            'transparentBackground' => 1
                        ),
                    ),
                    '15' => 'EFFECT',
                    '15.' => array(
                        'value' => 'gamma=1,5',
                    ),
		),
                'mask' => 'GIFBUILDER',
                'mask.' => array(
                    'XY' => $XY,
                    'backColor' => '#58cedd'
                ),
            );
            return $this->cObj->IMAGE($conf); 
            
        } //end of if($galleryFileExists)
        else 
        {
            return null;
        }
    }
}
?>