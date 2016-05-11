<?php 
if(!defined('TYPO3_MODE')) die ('Access denied.');

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';


/**
 * Add extension key here
 */
$nj_extkey = 'tx_njartgallery';
$nj_extkey_lang = 'nj_artgallery';
$nj_ext_title = 'njs Art Gallery';


/**
 * Registers a Plugin to be listed in the Backend. You also have to configure the Dispatcher in ext_localconf.php.
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Pi1',
    'LLL:EXT:'.$nj_extkey_lang.'/Resources/Private/Language/locallang_db.xlf:plugin.title'
);


/**
 * TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', $nj_ext_title.' setup');


/**
 * Flexform
 */
// Clean up the Flexform fields in the backend a bit
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,splash_layout';
// Add own flexform stuff.
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_'.$nj_extkey.'.xml');


/**
 * Hide table(s) in list view at backend
 */
$GLOBALS['TCA']['tx_njartgallery_domain_model_slidersheet']['ctrl']['hideTable'] = TRUE;