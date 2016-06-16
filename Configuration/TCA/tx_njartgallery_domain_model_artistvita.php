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


$type = [];
$type['general'] =	'--div--;'.$nj_collection_lang_file.'tab.general.generalInformation,hidden,sys_language_uid;;1,--palette--;Date;date,vtype,';
$type['study'] = $type['general'].'uni,degree,';
//$type['code']	=	$type['general'] . '--div--;'.$nj_ext_lang_file.'tab.model.content.code,code_lang,code,code_starting_line,--palette--;'.$nj_ext_lang_file.'label.model.content.codeHighlighting;code_highlight';



return [
	'ctrl' => [
		'crdate' => 'crdate',
		'default_sortby' => 'ORDER BY date_from DESC',
		'delete' => 'deleted',
		'dividers2tabs' => TRUE,
		'enablecolumns' => [
            'disabled' => 'hidden'
        ],
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($nj_ext_path) . 'Resources/Public/Icons/' . $nj_ext_key . '_domain_model_' . $nj_domain . '.svg',
		//'l10n_mode' => 'mergeIfNotBlank',
		'label' => 'date_from',
		'languageField' => 'sys_language_uid',
        'origUid' => 't3_origuid',
		'requestUpdate' => 'sys_language_uid',
		//'sortby' => 'sorting',
		'title' => $nj_ext_lang_file.'model.'.$nj_domain,
		'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
		'tstamp' => 'tstamp',
		'type' => 'vtype',
		'versioning_followPages' => TRUE,
        'versioningWS' => 2,
	],
	'feInterface' => [
        'fe_admin_fieldList' => 'title',
    ],
	'interface' => [
		'always_description' => 1,
		'maxDBListItems' => 100,
		'maxSingleDBListItems' => 500,
        'showRecordFieldList' => 'sorting',
    ],
	'columns' => [
		'content' => [
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.content',
			'config'  => [
				'type' => 'text',
				'cols' => 60,
				'rows' => 6,
			],
			'defaultExtras' => 'richtext[]',
		],
		'date_from' => [
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.from',
			'config'  => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim',
				'max'  => 25
			],
		],
		'date_to' => [
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.to',
			'config'  => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim',
				'max'  => 25
			],
		],
		'degree' => [
			'exclude' => 0,
			'label'   => $nj_ext_lang_file.'label.model.'.$nj_domain.'.degree',
			'config'  => [
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 255
			],
			'defaultExtras' => 'richtext[]',
		],
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
		'hidden' => [
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => [
				'type' => 'check'
			],
		],
		'l18n_diffsource' => [
			'config' => [
				'type'=>'passthrough'
			],
		],
		'l18n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'multiple' => '1',
				'itemsProcFunc' => 'N1coode\\NjCollection\\Utility\\Tca->getL18nParent',
				'items' => [
					['', 0],
				],
				'maxitems' => '1',
				'minitems' => '0'
			],
		],
		'sys_language_uid' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'change' => 'reload',
			'config' => [
				'type' => 'passthrough',
			],
		],
		'tstamp' => [
            'exclude' => 1,
            'label' => 'Creation date',
            'config' => [
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
            ],
        ],
		'uni' => [
			'exclude'	=> 0,
			'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.uni',
			'config'	=> [
				'type'                  => 'select',
				'foreign_table'         => $nj_ext_key.'_domain_model_uni',
				'foreign_table_where' 	=> 'ORDER BY '.$nj_ext_key.'_domain_model_uni.name',
				'size'                  => 5,
				'maxitems'              => 1,
				'minitems'				=> 0
			],
		],
		'vtype' => [
			'exclude'	=> 0,
			'label'		=> $nj_collection_lang_file.'label.general.type',
			'config'	=> [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'maxitems' => 1,
				'minitems' => 1,
				'items' => [
					[$nj_ext_lang_file.'select.general.type.jointExhibition', 'jointExhibition'],
					[$nj_ext_lang_file.'select.general.type.soloExhibition', 'soloExhibition'],
					[$nj_ext_lang_file.'select.general.type.artFair', 'artFair'],
					[$nj_ext_lang_file.'select.general.type.professional', 'professional'],
					[$nj_ext_lang_file.'select.general.type.collection','collection'],
					[$nj_ext_lang_file.'select.general.type.study', 'study']
				],
				'default' => 'jointExhibition',
			],
		],
    ],
	'types' => [
        '0' => ['showitem' => $type['general']],
		'study' => ['showitem' => $type['study']],
    ],
    'palettes' => [
        '1' => ['showitem' => 'l18n_parent'],
		'date' => ['showitem' => 'date_from,date_to', 'canNotCollapse' => '1'],
    ],
];