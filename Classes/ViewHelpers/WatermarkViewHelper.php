<?php
namespace N1coode\NjArtgallery\ViewHelpers;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class WatermarkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
	/**
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer ContentObject
	 */
	protected $cObj;
	
	/**
	 *	Discription following
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 * @param int $maxWidth
	 * @param int $maxHeight
	 * @param int $transparency
	 * @param string $title
	 * @param string $artist
	 * @return string  
	 */
	public function render(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image = null, $maxWidth = null, $maxHeight = null, $transparency = 65, $title = '', $artist='')
	{
		$this->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
		
		$watermarkFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('nj_artgallery').'Resources/Public/Gfx/watermark_berliner-galerie.png';
		//$watermarkFile = 'typo3conf/ext/nj_artgallery/Resources/Public/Gfx/watermark.png';
		$watermarFileExists = false;
		
		$originalImage = array();
		$originalImage['url'] = $image->getOriginalResource()->getPublicUrl();
		$originalImage['width'] = getimagesize($originalImage['url'])[0];
		$originalImage['height'] = getimagesize($originalImage['url'])[1];
		$originalImage['mime'] = getimagesize($originalImage['url'])['mime'];
		
		$watermarkImage = array();
		
		if(file_exists($watermarkFile))
		{
			$watermarkImage['url'] = $watermarkFile;
			$watermarkImage['width'] = getimagesize($watermarkImage['url'])[0];
			$watermarkImage['height'] = getimagesize($watermarkImage['url'])[1];
			$watermarkImage['mime'] = getimagesize($watermarkImage['url'])['mime'];
		}
		
		$ratio = 1;
		
		if($maxWidth != null)
		{
			$ratio = (int)$originalImage['width'] / (int)$maxWidth;
		}
		$originalImage['width'] = (int)((int)$originalImage['width'] / $ratio);
		$originalImage['height'] = (int)((int)$originalImage['height'] / $ratio);
		
		$XY = $originalImage['width'].','.$originalImage['height'];
		
		//0,0,[10.w],[10.h]
		//[10.w]*0.25,10,[10.w],[10.h]
		$boxDimensions = array();
		
		
		$boxHeight = 50;
		
		//$boxDimensions[0] = $originalImage['width'] * 0.25;
		$boxDimensions[0] = 0;
		$boxDimensions[1] = $originalImage['height'] * 0.75;
		$boxDimensions[2] = $originalImage['width'];
		$boxDimensions[3] = $originalImage['height'] - $boxDimensions[1] - ($originalImage['height'] * 0.1);
		
		$boxDimensions[0] = 0;
		$boxDimensions[1] = $originalImage['height'] - $boxHeight - 25;
		$boxDimensions[2] = $originalImage['width'];
		$boxDimensions[3] = $boxHeight;
		
		$iconHeight = $boxHeight - 10;
		// array imagettfbbox ( int size, int angle, string fontfile, string text )
		$iconCoordinates = imagettfbbox ( 
				$iconHeight, 
				0, 
				'typo3conf/ext/nj_artgallery/Resources/Public/Fonts/Lato-Italic.ttf', 
				'&#xf1fc;');
		if(isset($iconCoordinates[5]))
		{
			$iconWidth = $iconCoordinates[5];
			if($iconWidth < 0)
			{
				$iconWidth *=(-1);
			}
		}
		$iconWidth +=20;
		
		$ratioWatermark = 1;
		if($maxWidth != null)
		{
			$ratioWatermark = (int)$watermarkImage['width'] / ((int)$maxWidth - ((int)$maxWidth * 0.1));
		}
		$watermarkImage['width'] = (int)((int)$watermarkImage['width'] / $ratioWatermark);
		$watermarkImage['height'] = (int)((int)$watermarkImage['height'] / $ratioWatermark);
		
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($boxDimensions, 'boxDimensions');
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($XY, 'XY');
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($iconWidth, 'iconWidth');
		
		$watermarkDimensions = array();
		
		$XYwatermark = $watermarkImage['width'].','.$watermarkImage['height'];
		
		$offsetWatermark = ((int)$maxWidth - $watermarkImage['width']) / 2;
		$offsetWatermark .= ',';
		$offsetWatermark .= ($boxDimensions[1] - $watermarkImage['height']) / 2;
		$watermarkDimensions[0] = ((int)$maxWidth - $watermarkImage['width']) / 2;
		$watermarkDimensions[1] = $originalImage['height'] * 0.75;
		$watermarkDimensions[2] = $originalImage['width'];
		$watermarkDimensions[3] = $originalImage['height'] - $boxDimensions[1] - ($originalImage['height'] * 0.1);
		
		$titleOriginal = $title;
		if(strlen($title) > 32)
		{
			$title = substr($title, 0, 28).'...';
		}
		
		$watermark = array(
				'XY' => $XY,
				'format' => 'png',
				'transparentBackground' => 1,
				'transparentColor' => 'black',
				'offset' => '0,0',
				'25' => 'TEXT',
				'25.' => array(
					'text' => 'Berliner',
					'fontColor' => 'black',
					'fontFile' => 'typo3conf/ext/nj_artgallery/Resources/Public/Fonts/Lato-Italic.ttf',
					#'fontSize' => ($boxDimensions[3]-10),
					'fontSize' => '100',
					'offset' => '0,100',
					'align' => 'center',
					'maxWidth' => '250',
					'opacity' => 50,
					'shadow.' => array(
						'color' => '#efefef',
						'intensity' => '75',
						'opacity' => 75,
						//'blur' => '90',
						//'offset' => '10,10',
					),
					'hide' => '1',
					'hideButCreateMap' => 1,
					'emboss.' => array()
				),
				
		);
		
		
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($originalImage, 'XY');
		$conf = array(
			'titleText' => $titleOriginal.' - '.$artist.' | Berliner Galerie',
			'altText' => $titleOriginal.' - '.$artist.' | Berliner Galerie',
                        'params' => 'class="round-corners"',
                        'file' => 'GIFBUILDER',
			'file.' => array(
				'XY' => $XY,
				'format' => 'jpg',
				'quality' => 100,
				'10' => 'IMAGE',
				'10.' => array(
					'offset' => '0,0',
					'file' => $originalImage['url'],
					'file.' => array(
						'width' => $originalImage['width'],
						'height' => $originalImage['height'],
						'transparentBackground' => 1
					),
				),
				'15' => 'EFFECT',
				'15.' => array(
					'value' => 'sharpen=15|gamma=1,5|',
				),
					
// 				'18' => 'IMAGE',
// 				'18.' => array(
// 					'file' => 'GIFBUILDER',
// 					'file.' => array(
// 						'XY' => $XY,
// 						'format' => 'jpg',
// 						'transparentBackground' => 1,
// 						'transparentColor' => 'white',
// 						'10' => 'IMAGE',
// 						'10.' => array(
// 							'file' => $watermarkImage['url'],
// 							'file.' => array(
// 								'width' => $watermarkImage['width'],
// 								'height' => $watermarkImage['height'],
// 								'transparentBackground' => 1,
// 									'transparentColor' => 'white',
// 							),
// 							'offset' => $offsetWatermark,
// 						),
// 						'20' => 'EFFECT',
// 						'20.' => array(
// 								'value'=>'rotate=3|'
// 							)
						
// 					),
					
// 				),
					
				'18' => 'IMAGE',
				'18.' => array(
					'offset' => $offsetWatermark,
					'file' => $watermarkImage['url'],
					'file.' => array(
						'width' => $watermarkImage['width'],
						'height' => $watermarkImage['height'],
						'transparentBackground' => 1,
					),
					
				),
				
				
				'25' => 'TEXT',
				'25.' => array(
					'text' => '&#xf1fc;',
					'fontColor' => 'white',
					'fontFile' => 'typo3conf/ext/nj_artgallery/Resources/Public/Fonts/Fontawesome-4.3.0/fontawesome-webfont.ttf',
					'fontSize' => $iconHeight,
					'offset' => ($boxDimensions[0] + 10).','.($boxDimensions[1] + $boxHeight -10),
					
					'shadow.' => array(
						'color' => 'black',
						'intensity' => '100',
						'blur' => '75',
						'opacity' => '100',
						'offset' => '0,0',
					),
					'niceText' => '0',
				),		
					
				
				'33' => 'BOX',
				'33.' => array(
						'opacity' => 15,
						'dimensions' => $boxDimensions[0].','.$boxDimensions[1].','.$boxDimensions[2].','.$boxDimensions[3],
						'color' => 'black'
				),
				'21' => 'BOX',
				'21.' => array(
						'opacity' => 10,
						'dimensions' => $boxDimensions[0].','.($boxDimensions[1] - 3).','.$boxDimensions[2].',3',
						'color' => 'white'
				),
				'20' => 'BOX',
				'20.' => array(
						'opacity' => 20,
						'dimensions' => $boxDimensions[0].','.$boxDimensions[1].','.$boxDimensions[2].','.($boxDimensions[3] + 5),
						'color' => 'black'
				),
				'35' => 'BOX',
				'35.' => array(
						'opacity' => 65,
						'dimensions' => $iconWidth.','.$boxDimensions[1].',1,'.$boxDimensions[3],
						'color' => 'white'
				),
				'32' => 'TEXT',
				'32.' => array(
					'text' => $title,
					'fontColor' => 'white',
					'fontFile' => 'typo3conf/ext/nj_artgallery/Resources/Public/Fonts/FiraSans-Medium.ttf',
					'fontSize' => 14,
					'offset' => ($iconWidth + 10).','.($boxDimensions[1] + 15 + 5),
					#'maxWidth' => ($originalImage['width'] - $iconWidth - 10),
					'shadow.' => array(
						'color' => 'black',
						'intensity' => '100',
						#'blur' => '50',
						'opacity' => '100',
						'offset' => '1,1',
					),
					'antiAlias' => 1,
					'niceText' => 0,
				),
				'31' => 'TEXT',
				'31.' => array(
					'text' => $artist,
					'fontColor' => 'white',
					'fontFile' => 'typo3conf/ext/nj_artgallery/Resources/Public/Fonts/FiraSans-Regular.ttf',
					'fontSize' => 15,
					'offset' => ($iconWidth + 10).','.($boxDimensions[1] + 15 + 5 + 15 + 5),
			
					'shadow.' => array(
						'color' => 'black',
						'intensity' => '100',
						#'blur' => '50',
						'opacity' => '100',
						'offset' => '1,1',
					),
					'niceText' => '0',
				),
// 				'20' => 'IMAGE',
// 				'20.' => array(
					
// 					'file' => 'typo3conf/ext/nj_artgallery/Resources/Public/Gfx/overlay.png',
// 					'file.' => array(
// 							'width' => $originalImage['width'],
// 							'height' => $originalImage['height'],
// 							'antiAlias' => 1,
// 							'backColor' => '#cccccc'
// 					),
// 				)
			)
		);
		
		
		$conf2 = array(
			'file' => 'GIFBUILDER',
			'file.' => array(
				'XY' => $XY,
				'format' => 'jpg',
				'quality' => 100,

				'10' => 'IMAGE',
				'10.' => array(
					'file' => 'typo3conf/ext/nj_artgallery/Resources/Public/Gfx/white.png',
					'file.' => array(
						'width' => $originalImage['width'],
						'height' => $originalImage['height'],
						'transparentBackground' => 1
					),
					
				),
					
				'25' => 'TEXT',
				'25.' => array(
					'text' => '&#xf1fc;',
					'fontColor' => '#efefef',
					'fontFile' => 'typo3conf/ext/nj_artgallery/Resources/Public/Fonts/Fontawesome-4.3.0/fontawesome-webfont.ttf',
					#'fontSize' => ($boxDimensions[3]-10),
						'fontSize' => ($boxDimensions[3]*3),
					'offset' => ($boxDimensions[0] + 10).','.($boxDimensions[1] + 10),
					'align' => 'l,t',
					//'hideButCreateMap' => 1,
					'shadow.' => array(
						'color' => 'black',
						'intensity' => '100',
						'blur' => '75',
						'opacity' => '100',
						'offset' => '0,0',
					),
					'niceText' => '0',
				),		
			),
		);
		
		
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($conf, 'conf');
		$fontSize = 100;
		$coordinates = imagettfbbox ( $fontSize, 0, "typo3conf/ext/nj_artgallery/Resources/Public/Fonts/Lato-Italic.ttf", "Berliner");
		while($coordinates[2] > 250)
		{
			$fontSize--;
			$coordinates = imagettfbbox ( $fontSize, 0, "typo3conf/ext/nj_artgallery/Resources/Public/Fonts/Lato-Italic.ttf", "Berliner");
		}
		
		
		
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($coordinates, 'coordinates');
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($fontSize, 'fontSize');
		$conf3 = array(
				'file' => 'GIFBUILDER',
				'file.' => array(
						'XY' => $XY,
						'format' => 'jpg',

						'10' => 'BOX',
						'10.' => array(
								'dimensions' => '0,0,'.$originalImage['width'].','.$originalImage['height'],
								'color' => 'white'
						),
						
						
						'25' => 'TEXT',
						'25.' => array(
								'text' => 'Berliner',
								'fontColor' => 'white',
								'fontFile' => 'typo3conf/ext/nj_artgallery/Resources/Public/Fonts/Lato-Italic.ttf',
								#'fontSize' => ($boxDimensions[3]-10),
								'fontSize' => '100',
								'offset' => '0,100',
								'align' => 'center',
								'maxWidth' => '250',
								'shadow.' => array(
									'color' => 'black',
									'intensity' => '75',
									//'opacity' => 75,
									'blur' => '90',
									//'offset' => '10,10',
								),
						),
						'15' => 'SHADOW',
						'15.' => array(
								'textObjNum' => 25,
								'color' => 'black',
								'intensity' => '75',
								//'opacity' => 75,
								//'blur' => '90',
								//'offset' => '10,10',
						),
				)
		);
		
		//$preview = $this->pobj->cObj->IMG_RESOURCE($conf);
		return $this->cObj->IMAGE($conf); 
	}
}
?> 