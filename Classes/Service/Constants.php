<?php
namespace N1coode\NjArtgallery\Service;

/**
 * @author n1coode
 * @package nj_page
 */
class Constants
{ 
	const NJ_AJAX_PAGETYPE	= '6512784255379';
	const NJ_EXT_DOMAIN		= 'N1coode';
	const NJ_EXT_KEY        = 'tx_njartgallery';
	const NJ_EXT_LIST_TYPE	= 'njartgallery_pi1';
	const NJ_EXT_NAMESPACE	= 'NjArtgallery';
	const NJ_EXT_PATH       = 'nj_artgallery';
    const NJ_EXT_TITLE      = 'njs Art gallery';
	const NJ_EXT_LANG_FILE_FRONTEND	= 'LLL:EXT:nj_artgallery/Resources/Private/Language/locallang.xlf:';
	const NJ_EXT_LANG_FILE_BACKEND	= 'LLL:EXT:nj_artgallery/Resources/Private/Language/locallang_db.xlf:';
	
	/**
	 * @return array All constants
	 */
	public static function extValues()
	{
		return [
			'ajax'		=> [
				'pagetype' => self::NJ_AJAX_PAGETYPE,
			],
			'domain'	=> self::NJ_EXT_DOMAIN,
			'key'		=> self::NJ_EXT_KEY,
			'namespace'	=> self::NJ_EXT_NAMESPACE,
			'path'		=> self::NJ_EXT_PATH,
			'lang'		=> [
				'backend'	=> self::NJ_EXT_LANG_FILE_BACKEND,
				'frontend'	=> self::NJ_EXT_LANG_FILE_FRONTEND,
			]
		];
	}
}