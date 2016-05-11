<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
use N1coode\NjArtgallery\Service\Constants as Constants;

$nj_ext_key			= Constants::NJ_EXT_KEY;
$nj_ext_namespace	= Constants::NJ_EXT_NAMESPACE;
$nj_ext_path		= Constants::NJ_EXT_PATH;
$nj_ext_title		= Constants::NJ_EXT_TITLE;

$nj_ext_lang_file			= Constants::NJ_EXT_LANG_FILE_BACKEND;
$nj_collection_lang_file	= 'LLL:EXT:nj_collection/Resources/Private/Language/locallang_db.xlf:';

$nj_domain_model = 'ArtistVita';
$nj_domain = strtolower($nj_domain_model);

return array(
	'ctrl' => array(
        'title' => $nj_ext_lang_file.'model.'.$nj_domain,
        'label' => 'date_from',
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
        'default_sortby' => 'ORDER BY date_from DESC',
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
                'type' => 'passthrough',
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
		'content' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.content',
			'config'  => array(
				'type' => 'text',
				'cols' => 60,
				'rows' => 6,
			),
			'defaultExtras' => 'richtext[]',
		),
		'date_from' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.from',
			'config'  => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim',
				'max'  => 25
			)
		),
		
		'date_to' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.to',
			'config'  => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim',
				'max'  => 25
			)
		),
		'foreign_table' => array(
			'exclude' => 0,
			'label' => 'foreignTable',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'foreign_uid' => array(
			'exclude'	=> 1,
			'label'		=> 'foreignUid',
			'config'	=> array(
					'type' => 'input',
					'size' => 6,
					'eval' => '',
			),
		),
		'vtype' => array(
			'exclude'	=> 0,
			'label'		=> 'type //TODO',
			'config'	=> array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'maxitems' => 1,
				'minitems' => 1,
				'items' => array(
					array('Joint exhibitiions', 'jointExhibitions'),
					array('Single exhibitions', 'singleExhibitions'),
					array('Art fairs', 'artFairs'),
					array('Professional activities', 'professional'),
					array('Collections','collections'),
					array('Studies', 'studies')
				),
				
			)
		),
    ),
	'types' => array(
        '0' => array('showitem' => 'hidden,sys_language_uid;;1,--palette--;Date;date,vtype,content' )
    ),
    'palettes' => array(
        '1' => array('showitem' => 'l18n_parent'),
		'date' => array('showitem' => 'date_from,date_to', 'canNotCollapse' => '1'),
    ),
);