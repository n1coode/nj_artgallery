<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
use N1coode\NjArtgallery\Service\Constants as Constants;

$nj_ext_key			= Constants::NJ_EXT_KEY;
$nj_ext_namespace	= Constants::NJ_EXT_NAMESPACE;
$nj_ext_path		= Constants::NJ_EXT_PATH;
$nj_ext_title		= Constants::NJ_EXT_TITLE;

$nj_ext_lang_file			= Constants::NJ_EXT_LANG_FILE_BACKEND;
$nj_collection_lang_file	= 'LLL:EXT:nj_collection/Resources/Private/Language/locallang_db.xlf:';

$nj_domain_model = 'Artist';
$nj_domain = strtolower($nj_domain_model);

return array(
	'ctrl' => array(
        'title' => $nj_ext_lang_file.'model.'.$nj_domain,
        'label' => 'last_name',
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
        'default_sortby' => 'ORDER BY last_name ASC',
        //'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden'
        ),
        'requestUpdate' => 'sys_language_uid,finished_training',
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
		
		'advertise' => array(
			'exclude' => 0,
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.advertise',
			'config' => array(
				'type'      => 'check',
				'default'   => 0
			)
		),
		'category' => array(
			'exclude'	=> 0,
			'label'		=> $nj_collection_lang_file.'label.general.category',
			'config'	=> array(
				'type' 					=> 'select',
				'foreign_table' 		=> $nj_ext_key.'_domain_model_artistcat',
				'foreign_table_where' 	=> 'ORDER BY '.$nj_ext_key.'_domain_model_artistcat.name',
				'size'					=> 5,
				'maxitems' 				=> 10,
				'minitems'				=> 0
			)
		),
		'city' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.city',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'country' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.country',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'email' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.email',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'finished_training' => array(
			'exclude' => 0,
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.finishedTraining',
			'change' => 'reload',
			'config' => array(
				'type'      => 'check',
				'default'   => 0
			)
		),
		'first_name' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.firstName',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'last_name' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.lastName',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'permanent' => array(
			'exclude' => 0,
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.permanent',
			'change' => 'reload',
			'config' => array(
				'type'      => 'check',
				'default'   => 0
			)
		),
		'enable_entire_name' => array(
			'exclude' => 0,
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.enableEntireName',
			'config' => array(
				'type'      => 'check',
				'default'   => 0
			)
		),
		'street' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.street',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'summary' => array(
			'exclude' => 0,
			'label'   => $nj_ext_lang_file.'label.model.'.$nj_domain.'.summary',
			'config'  => array(
				'type' => 'text',
				'cols' => 60,
				'rows' => 6,
			),
			'defaultExtras' => 'richtext[]',
		),
		'universities' => array(
			'displayCond' => 'FIELD:finished_training:>:0',
			'exclude'	=> 0,
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.uni',
			'config'	=> array(
				'type'                  => 'select',
				'foreign_table'         => $nj_ext_key.'_domain_model_uni',
				'foreign_table_where' 	=> 'ORDER BY '.$nj_ext_key.'_domain_model_uni.name',
				'size'                  => 5,
				'maxitems'              => 10,
				'minitems'				=> 0
			)
		),
		'vita' => Array(
			'exclude' => 0,
			'label'   => $nj_ext_lang_file.'label.model.'.$nj_domain.'.vita',
			'config' => Array(
				'type' => 'inline',
				
				'foreign_table' => $nj_ext_key.'_domain_model_artistvita',
				'foreign_sortby' => 'sorting',
				'foreign_field' => 'foreign_uid',
				'foreign_table_field' => 'foreign_table',
				'foreign_table_where' => ' sys_language_uid = ###REC_FIELD_sys_language_uid###',
				'maxitems' => 99,
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			),
		),
		'website' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.website',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'zip_code' => array(
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.zipCode',
			'config'  => array(
					'type' => 'input',
					'size' => 15,
					'eval' => 'trim',
					'max'  => 256
			)
		),
    ),
	'types' => array(
        '0' => array('showitem' => 
			  '--div--;'.$nj_ext_lang_file.'tab.generalInformation,hidden,sys_language_uid;;1,--palette--;'.$nj_collection_lang_file.'label.general.name;name,category,permanent,advertise,summary,'
			. '--div--;'.$nj_ext_lang_file.'tab.vita,finished_training,universities,vita,'
			. '--div--;'.$nj_ext_lang_file.'tab.additionalInformation,email,website,street,city,zip_code,country' )
    ),
    'palettes' => array(
        '1' => array('showitem' => 'l18n_parent'),
		'nj_artgallery_artist_dimensions' => array(
            'showitem'          => 'width, height,',
            'canNotCollapse'    => '1',
        ),
		'name' => array('showitem' => 'last_name,first_name,enable_entire_name','canNotCollapse' => '1'),
    ),
);