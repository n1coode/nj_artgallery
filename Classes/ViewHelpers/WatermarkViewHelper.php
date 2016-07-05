<?php
namespace N1coode\NjArtgallery\ViewHelpers;

/**
 * @author n1coode
 * @package nj_artgallery
 */
class WatermarkViewHelper extends \N1coode\NjPage\ViewHelpers\AbstractViewHelper {
	
	const _type_fileOriginal			= 'fileOriginal';
	const _type_fileWatermark			= 'fileWatermark';
	
	const _arg_includeLabel				= 'includeLabel';
	
	const _attr_image					= 'image';
	const _attr_label					= 'label';
	const _attr_watermark				= 'watermark';
	
	const _labelHeight					= 50;
	const _labelMarginBottom			= 25;
	const _maxLengthArtworkTitle		= 32;
	const _image_maxWidth				= 640;
	const _watermark_transparency		= 33;
	
	const _textShadow = [
		'color' => 'black',
		'intensity' => '100',
		'blur' => '10',
		'opacity' => '100',
		'offset' => '1,1',
	];
	
	/**
	 * @var array 
	 */
	protected $attributes = [
		'image' => [],
		'label' => [],
		'watermark' => []
	];
	
	/**
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	protected $cObj;
	
	
	/**
	 * @var array 
	 * ['height','width','x','y'] 
	 */
	protected $iconAttributes = NULL;
	
	/**
	 * @var array 
	 * ['height','width','mime','url'] 
	 */
	protected $imageAttributes = NULL;
	
	/**
	 * @var array 
	 * ['height','width','x','y'] 
	 */
	protected $labelAttributes = NULL;
	
	/**
	 * @var array 
	 * ['height','width','x','y','offset'] 
	 */
	protected $watermarkAttributes = NULL;
	
	
	
	/**
	 *
	 * @var array
	 */
	protected $conf;
	
	/**
	 * @var array
	 */
	protected $boxDimensions = NULL;
	
	/**
	 * @var array 
	 */
	protected $labelDimensions = NULL;
	
	/**
	 * @var int 
	 */
	protected $iconHeight = NULL;
	
	/**
	 * @var array 
	 */
	protected $iconDimensions = NULL;
	
	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $imageFile = NULL;
	
	/**
	 * @var int 
	 */
	protected $maxHeight = NULL;
	
	/**
	 * @var int 
	 */
	protected $maxWidth = NULL;
	
	/**
	 * @var array 
	 */
	protected $originalImage = NULL;
	
	/**
	 * @var array 
	 */
	protected $watermarkDimensions = NULL;
	
	/**
	 * @var array 
	 */
	protected $watermarkImage = NULL;
	
	/**
	 * @var string 
	 */
	protected $artworkTitle = NULL;
	
	
	/**
	 * 
	 */
	public function initialize() 
	{
		if($this->argumentIsSet('image'))
		{
			$this->imageFile = $this->argumentGet('image');
			$this->setOriginalImage();
			$this->setWatermarkImage();
			
		}
		if($this->argumentIsTrue('resize')) {
			if($this->argumentIsSet('maxHeight')) {
				$this->maxHeight = $this->argumentGet('maxHeight');
			}
			else {
				$this->maxWidth = $this->argumentIsSet('maxWidth') ? $this->argumentGet('maxWidth') : self::_image_maxWidth;
			}
		}
		$this->setAttributes();
		$this->setArtworkTitle();
	}
	
	/**
	 * Hint: $this->registerArgument('value', 'mixed', 'The value to output', FALSE, NULL);
	 * @return void
	 */
	public function initializeArguments() 
	{
		$this->registerArgument('image','\TYPO3\CMS\Extbase\Domain\Model\FileReference', 'The artwork image.',TRUE,NULL);
		$this->registerArgument('artistName', 'string', 'Name of the artist.',FALSE,NULL);
		$this->registerArgument('maxHeight', 'int', 'Maximum height of the rendered image.',FALSE,NULL);
		$this->registerArgument('maxWidth', 'int', 'Maximum width of the rendered image.',FALSE,NULL);
		$this->registerArgument('artworkTitle', 'string', 'Title of the artwork.',FALSE,NULL);
		$this->registerArgument('watermarkTransparency', 'int', 'Transparency of the overlayed watermark.',FALSE, NULL);
		$this->registerArgument(self::_arg_includeLabel, 'boolean', 'Option if a label (artwork info for example) should be printed on the image.', FALSE, TRUE);
		$this->registerArgument('resize', 'boolean', 'Option if artwork should be resized.',FALSE,TRUE);
		$this->registerArgument('keepRatio', 'boolean', 'Option if ratio of the image should be preserved.', FALSE, TRUE);
		$this->registerArgument('crop','boolean','Option if image should be croped',FALSE,FALSE);
		
	}
	
	
	/**
	 * @return string  
	 */
	public function render()
	{
		if($this->imageFile !== NULL) {
			$this->setBoxDimensions();
			
			$this->setIconDimensions();
			$this->buildImageRenderConfig();
			
			$this->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
			return $this->cObj->render($this->cObj->getContentObject('IMAGE'), $this->conf);
		} else {
			return "Fehler: kein image";
		}
		
	}
	
	
	protected function buildImageRenderConfig() {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->watermarkDimensions);
		$altTitle = '';
		if($this->argumentIsSet('artworkTitle') || $this->argumentIsSet('artistName')) {
			if($this->argumentIsSet('artworkTitle')) {
				$altTitle .= $this->artworkTitle; 
			}
			if($this->argumentIsSet('artistName')) {
				if($this->argumentIsSet('artworkTitle')) {
					$altTitle .= ' - ';
				}
				$altTitle .= $this->argumentGet('artistName'); 
			}
			$altTitle .= ' | ';
		}
		
		$altTitle .= 'Berliner Galerie'; //TODO: übergeben
		
		$this->conf = [
			'titleText' => $altTitle,
			'altText' => $altTitle,
			'params' => 'class="round-corners"',
			'file' => 'GIFBUILDER',
			'file.' => [
				'XY' => $this->attributes[self::_attr_image]['width'].','.$this->attributes[self::_attr_image]['height'],
				'format' => 'jpg',
				'quality' => 100,
				'10' => 'IMAGE',
				'10.' => [
					'offset' => '0,0',
					'file' => $this->attributes[self::_attr_image]['url'],
					'file.' => [
						'width' => $this->attributes[self::_attr_image]['width'],
						'height' => $this->attributes[self::_attr_image]['height'],
						'transparentBackground' => 1
					],
				],
				'15' => 'IMAGE',
				'15.' => [
					'offset' => $this->attributes[self::_attr_watermark]['offset'],
					'file' => $this->attributes[self::_attr_watermark]['url'],
					'file.' => [
						'width' => $this->attributes[self::_attr_watermark]['width'],
						'height' => $this->attributes[self::_attr_watermark]['height'],
						'transparentBackground' =>0,
						
					],
				],
			]
		];
		
		if($this->argumentIsTrue(self::_arg_includeLabel)) {
			$lineHeight = 5;
			
			$labelConf  = [
				'file.' => [
					'20' => 'BOX',
					'20.' => [
						'opacity' => 25,
						'dimensions' => $this->attributes[self::_attr_label]['x'].','.$this->attributes[self::_attr_label]['y'].','.$this->attributes[self::_attr_label]['width'].','.($this->attributes[self::_attr_label]['height'] - (4 * $lineHeight)),
						'color' => 'white'
					],
					'25' => 'TEXT',
					'25.' => [
						'text' => '&#xf1fc;',
						'fontColor' => 'white',
						'fontFile' => 'typo3conf/ext/nj_artgallery/Resources/Public/Fonts/Fontawesome-4.3.0/fontawesome-webfont.ttf',
						'fontSize' => 30,
						'offset' => (10).','.($this->attributes['image']['height'] - $this->attributes['label']['marginBottom'] - 15),

						'shadow.' => [
							'color' => 'black',
							'intensity' => '100',
							'blur' => '75',
							'opacity' => '100',
							'offset' => '0,0',
						],
						'niceText' => '0',
					],
					'30' => 'BOX',
					'30.' => [
						'opacity' => 33,
						'dimensions' => $this->attributes[self::_attr_label]['x'].','.($this->attributes[self::_attr_label]['y'] + $lineHeight).','.$this->attributes[self::_attr_label]['width'].','.($this->attributes[self::_attr_label]['height'] - (2 * $lineHeight)),
						'color' => 'black'
					],
					'35' => 'BOX',
					'35.' => [
						'opacity' => 25,
						'dimensions' => $this->attributes[self::_attr_label]['x'].','.($this->attributes[self::_attr_label]['y'] + $this->attributes[self::_attr_label]['height'] - $lineHeight).','.$this->attributes[self::_attr_label]['width'].','.$lineHeight,
						'color' => 'white'
					],
				]
			];
			$this->conf = array_replace_recursive($this->conf, $labelConf);
		}
				
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->conf);
	}
	
	
	protected function setArtworkTitle()
	{
		if($this->argumentIsSet('artworkTitle'))
		{
			$this->artworkTitle = $this->argumentGet('artworkTitle');
		}
	}
	
	/**
	 * @return string
	 */
	protected function getArtworkTitleShort()
	{
		if(strlen($this->artworkTitle) > self::_maxLengthArtworkTitle) {
			return substr($this->artworkTitle, 0, (self::_maxLengthArtworkTitle - 4)).'...';
		}
		else {
			return $this->artworkTitle;
		}
	}
	
	
	protected function setBoxDimensions()
	{
		$XY = $this->originalImage['width'].','.$this->originalImage['height'];
		$this->boxDimensions = [];
		$boxHeight = 50; //??; TODO
		
		$this->boxDimensions[0] = 0;
		$this->boxDimensions[1] = $this->originalImage['height'] - self::_labelHeight - 25;
		$this->boxDimensions[2] = $this->originalImage['width'];
		$this->boxDimensions[3] = self::_labelHeight;
	}

	
	
	protected function setLabelDimensions()
	{
		$this->labelDimensions = [
			'x'			=>'',
			'y'			=> '',
			'width'		=> $this->originalImage['width'] - $this->iconDimensions,
			'height'	=> self::_labelHeight
		];
	}
	
	protected function setDimensions()
	{
		
	}

	/**
	 * 
	 */
	protected function setIconDimensions()
	{
		$this->iconDimensions = [
			'height' => self::_labelHeight - 10,
			'width' => 0
		];
		
		$iconCoordinates = imagettfbbox ( 
			$iconHeight, 
			0, 
			'typo3conf/ext/nj_artgallery/Resources/Public/Fonts/Lato-Italic.ttf', 
			'&#xf1fc;'
		);
		if(isset($iconCoordinates[5]))
		{
			$this->iconDimensions['width'] = $iconCoordinates[5];
			if($this->iconDimensions['width'] < 0)
			{
				$this->iconDimensions['width'] *=(-1);
			}
		}
		$this->iconDimensions['width'] +=20;
	}

	/**
	 * @return void
	 */
	public function setOriginalImage() {
		$this->originalImage = [];
		$this->originalImage['url'] = $this->imageFile->getOriginalResource()->getPublicUrl();
		$this->originalImage['width'] = getimagesize($this->originalImage['url'])[0];
		$this->originalImage['height'] = getimagesize($this->originalImage['url'])[1];
		$this->originalImage['mime'] = getimagesize($this->originalImage['url'])['mime'];
		
		$this->setImageDimension(self::_type_fileOriginal);
	}
	
	
	protected function setAttributes() {
		$this->setAttributesImage();
		$this->setAttributesLabel();
		$this->setAttributesWatermark();
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->attributes);
	}
	
	
	
	
	protected function setAttributesImage() {
		$imageUrl = $this->imageFile->getOriginalResource()->getPublicUrl();
		$this->attributes = [
			self::_attr_image => [
				'height'	=> getimagesize($imageUrl)[1],
				'mime'		=> getimagesize($imageUrl)['mime'],
				'url'		=> $imageUrl,
				'width'		=> getimagesize($imageUrl)[0],
			],
		];
		
		
		if($this->argumentIsTrue('resize'))
		{
			if($this->argumentIsTrue('keepRatio')) {
				
				if($this->argumentIsSet('maxHeight')) {
					if( (int)$this->argumentGet('maxHeight') < (int)$this->attributes[self::_attr_image]['height'] ) {
						$this->attributes[self::_attr_image]['height'] = $this->argumentGet('maxHeight');
						$ratio = (int)$this->originalImage['height'] / (int)$this->attributes[self::_attr_image]['height'];
						$this->attributes[self::_attr_image]['width'] = (int)$this->originalImage['width'] / $ratio;
					}
				}
				else {
					
				}
			}
			else {
				
			}
		} //end of $this->argumentIsTrue('resize')
		else {
			//nothing TODO
		}
	}
	
	
	protected function setAttributesLabel() {
		if($this->argumentIsTrue(self::_arg_includeLabel)) {
			$this->attributes[self::_attr_label]['height'] = self::_labelHeight;
			$this->attributes[self::_attr_label]['width'] = $this->attributes[self::_attr_image]['width'];
			$this->attributes[self::_attr_label]['marginBottom'] = self::_labelMarginBottom;
			$this->attributes[self::_attr_label]['x'] = '0';
			$this->attributes[self::_attr_label]['y'] = $this->attributes[self::_attr_image]['height'] - $this->attributes[self::_attr_label]['height'] - $this->attributes[self::_attr_label]['marginBottom'];
		}
	}
	
	
	protected function setAttributesWatermark()
	{
		$ratio = ($this->attributes[self::_attr_image]['width'] / $this->watermarkImage['width']) * 0.9;
		
		$this->attributes[self::_attr_watermark]['width'] = ($this->watermarkImage['width'] * $ratio);
		$this->attributes[self::_attr_watermark]['height'] = ($this->watermarkImage['height'] * $ratio);
		
		$this->attributes[self::_attr_watermark]['x'] = (((int)$this->attributes[self::_attr_image]['width'] - (int)$this->attributes[self::_attr_watermark]['width']) / 2);
		if($this->argumentIsTrue(self::_arg_includeLabel)) {
			$labelHeight = $this->attributes[self::_attr_label]['height'] + $this->attributes[self::_attr_label]['marginBottom'];
			$this->attributes[self::_attr_watermark]['y'] = (((int)$this->attributes[self::_attr_image]['height'] - $labelHeight - (int)$this->attributes[self::_attr_watermark]['height']) / 2);
		}
		else {
			$labelHeight = $this->attributes[self::_attr_label]['height'] + $this->attributes[self::_attr_label]['marginBottom'];
			$this->attributes[self::_attr_watermark]['y'] = (((int)$this->attributes[self::_attr_image]['height'] - (int)$this->attributes[self::_attr_watermark]['height']) / 2);
		}
		$this->attributes[self::_attr_watermark]['offset'] = $this->attributes[self::_attr_watermark]['x'].','.$this->attributes[self::_attr_watermark]['y'];
		$this->attributes[self::_attr_watermark]['url'] = $this->watermarkImage['url'];
	}
	
	

	
	
	
	/**
	 * @return void
	 */
	public function setWatermarkImage() {
		
		$watermarkFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('nj_artgallery').'Resources/Public/Gfx/watermark_berliner-galerie_4.png';
		if(file_exists($watermarkFile))
		{
			$this->watermarkImage = [];
			$this->watermarkImage['url'] = $watermarkFile;
			$this->watermarkImage['width'] = getimagesize($this->watermarkImage['url'])[0];
			$this->watermarkImage['height'] = getimagesize($this->watermarkImage['url'])[1];
			$this->watermarkImage['mime'] = getimagesize($this->watermarkImage['url'])['mime'];
			
			$this->setImageDimension(self::_type_fileWatermark);
		}
	}
	
	
	/**
	 * @param string $type
	 */
	public function setImageDimension($type) {
		$ratio = 1;
		
		if($this->argumentGet('maxWidth') != NULL)
		{
			switch($type) {
				case self::_type_fileOriginal:
					$ratio = (int)$this->originalImage['width'] / (int)$this->maxWidth;
					$this->originalImage['width'] = (int)((int)$this->originalImage['width'] / $ratio);
					$this->originalImage['height'] = (int)((int)$this->originalImage['height'] / $ratio);
					break;
				case self::_type_fileWatermark:
					$ratio = (int)$this->watermarkImage['width'] / ((int)$this->maxWidth - ((int)$this->maxWidth * 0.1));
					$this->watermarkImage['width'] = (int)((int)$this->watermarkImage['width'] / $ratio);
					$this->watermarkImage['height'] = (int)((int)$this->watermarkImage['height'] / $ratio);
					break;
				default:
					//nothing todo
				;
			}
		}
	}
}