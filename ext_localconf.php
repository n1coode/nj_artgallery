<?php
if(!defined('TYPO3_MODE')) die ('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY] = unserialize($_EXTCONF);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'N1coode.'.$_EXTKEY,
    'Pi1',
    array(
		'Ajax' => 'image',
        'Artist' => 'index, list, focus',
        'Artwork' => 'index, focus, quoteRequest, showcase, showAjax',
        'Header' => 'artists,contact,exhibitions,index,standard,startpage',
        'Exhibition' => 'actual, actualTeaser, alarm, index, list, focus, tinyList'
    ),
    // non-cacheable actions
    array( 
		'Ajax' => 'image',
        'Artist' => 'index, list, focus',
        'Artwork' => 'index, focus, quoteRequest, showcase, showAjax',
        'Header' => 'artists,contact,exhibitions,index,standard,startpage',
        'Exhibition' => 'actual, actualTeaser, alarm, index, list, focus, tinyList'
    )
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY] = 'EXT:nj_artgallery/Classes/Hooks/PageLayoutView.php:N1coode\NjArtgallery\Hooks\PageLayoutView';