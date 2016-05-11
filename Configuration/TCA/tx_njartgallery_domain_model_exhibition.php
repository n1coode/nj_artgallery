<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
use N1coode\NjArtgallery\Service\Constants as Constants;

$nj_ext_key			= Constants::NJ_EXT_KEY;
$nj_ext_namespace	= Constants::NJ_EXT_NAMESPACE;
$nj_ext_path		= Constants::NJ_EXT_PATH;
$nj_ext_title		= Constants::NJ_EXT_TITLE;

$nj_ext_lang_file			= Constants::NJ_EXT_LANG_FILE_BACKEND;
$nj_collection_lang_file	= 'LLL:EXT:nj_collection/Resources/Private/Language/locallang_db.xlf:';

$nj_domain_model = 'Exhibition';
$nj_domain = strtolower($nj_domain_model);

return array(
	'ctrl' => array(
        'title' => $nj_ext_lang_file.'model.'.$nj_domain,
        'label' => 'vernissage_date',
        //'l10n_mode' => 'mergeIfNotBlank',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'dividers2tabs' => TRUE,
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
		'type' => '',
        'default_sortby' => 'ORDER BY vernissage_date DESC',
        //'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden'
        ),
        'requestUpdate' => 'sys_language_uid',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($nj_ext_path) . 'Resources/Public/Icons/' . $nj_ext_key . '_domain_model_' . $nj_domain . '.svg',
    ),
	'interface' => array(
        'showRecordFieldList' => 'sorting',
		'maxDBListItems' => 100,
		'maxSingleDBListItems' => 500,
		'always_description' => 1,
    ),
	'feInterface' => array(
        'fe_admin_fieldList' => 'title',
    ),
	'columns' => array(
        'tstamp' => Array (
            'exclude' => 1,
            'label' => 'Creation date',
            'config' => Array (
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
            )
        ),
        'sys_language_uid' => Array (
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
            'change' => 'reload',
            'config' => Array (
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => Array(
                    Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
                    Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
                )
            )
        ),

        'l18n_parent' => Array (
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
            'config' => array (
                'type' => 'select',
                'multiple' => '1',
                'itemsProcFunc' => 'N1coode\\NjCollection\\Utility\\Tca->getL18nParent',
                'items' => Array (
                    Array('', 0),
                ),
                'maxitems' => '1',
                'minitems' => '0'
            ),
        ),
        'l18n_diffsource' => Array(
            'config'=>array(
                'type'=>'passthrough'
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config'  => array(
                'type' => 'check'
            )
        ),
		'artists' => Array (
			'exclude' => 0,
            'displayCond' => 'FIELD:sys_language_uid:<=:0',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'hideDiff,defaultAsReadonly',
            'label'   => $nj_ext_lang_file.'label.general.artists',
            'config' => Array (
                'type' => 'select',
                'foreign_table' => $nj_ext_key.'_domain_model_artist',
				'foreign_table_where' => 'AND '.$nj_ext_key.'_domain_model_artist.pid=###CURRENT_PID### ORDER BY '.$nj_ext_key.'_domain_model_artist.last_name',
				'size' => 10,
				'multiple' => 1,
				'maxitems' => 1000,
			),
        ),
		'artworks' => Array (
			'exclude' => 0,
            'displayCond' => 'FIELD:sys_language_uid:<=:0',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'hideDiff,defaultAsReadonly',
            'label'   => $nj_ext_lang_file.'label.general.artworks',
            'config' => Array (
                'type' => 'select',
                'foreign_table' => $nj_ext_key.'_domain_model_artwork',
				'foreign_table_where' => 'AND '.$nj_ext_key.'_domain_model_artwork.pid=###CURRENT_PID### ORDER BY '.$nj_ext_key.'_domain_model_artwork.title',
				'size' => 10,
				'multiple' => 1,
				'maxitems' => 1000,
			),
        ),
		'description' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.description',
			'config'  => array(
				'type' => 'text',
				'cols' => 60,
				'rows' => 6,
			),
			'defaultExtras' => 'richtext[]',
		),
		'exhibition_start' => array(
			'exlude'		=> 0,
			'displayCond'	=> 'FIELD:sys_language_uid:<=:0',
			'label'			=> $nj_ext_lang_file.'label.model.'.$nj_domain.'.exhibitionStart',
			'config' 	=> array(
				'type' 	=> 'input',
				'size'	=> 20,
				'eval'	=> 'date',
			)
		),
		'exhibition_end' => array(
			'exlude'		=> 0,
			'displayCond'	=> 'FIELD:sys_language_uid:<=:0',
			'label'			=> $nj_ext_lang_file.'label.model.'.$nj_domain.'.exhibitionEnd',
			'config'		=> array(
				'type' 	=> 'input',
				'size'	=> 20,
				'eval'	=> 'date',
			)
		),
		'impressions' => array(
			'exclude' => 1,
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.impressions',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'impressions',
                array('minitems'=>0,'maxitems'=>99),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),

		'installation' => array(
			'exclude' => 1,
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.installation',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
					'installation',
					array('minitems'=>0,'maxitems'=>99),
					$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'teaser_image' => array(
			'exclude' => 1,
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.teaserImage',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
					'teaserImage',
					array('minitems'=>0,'maxitems'=>1),
					$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
        'title' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.title',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'type' => array(
			'exclude' => 0,
			'displayCond' => 'FIELD:sys_language_uid:<=:0',
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.type',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
						array($nj_ext_lang_file.'select.model.'.$nj_domain.'.type.jointExhibition', 0),
						array($nj_ext_lang_file.'select.model.'.$nj_domain.'.type.soloExhibition', 1)
				)
			)
		),
		'vernissage_date' => array(
			'exlude'	=> 0,
			'label'		=> $nj_ext_lang_file.'label.model.'.$nj_domain.'.vernissageDate',
			'config' 	=> array(
				'type' 	=> 'input',
				'size'	=> 20,
				'eval'	=> 'datetime',
			)
		),
    ),
	'types' => array(
        '0' => array('showitem' => 
			  '--div--;'.$nj_ext_lang_file.'tab.generalInformation,hidden,sys_language_uid;;1,title,type,description,vernissage_date,exhibition_start,exhibition_end,teaser_image,impressions,installation,'
			. '--div--;'.$nj_ext_lang_file.'tab.artistsAndArtworks,artists,artworks' )
    ),
    'palettes' => array(
        '1' => array('showitem' => 'l18n_parent'),
    ),
);