<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
use N1coode\NjArtgallery\Service\Constants as Constants;

$nj_ext_key			= Constants::NJ_EXT_KEY;
$nj_ext_namespace	= Constants::NJ_EXT_NAMESPACE;
$nj_ext_path		= Constants::NJ_EXT_PATH;
$nj_ext_title		= Constants::NJ_EXT_TITLE;

$nj_ext_lang_file			= Constants::NJ_EXT_LANG_FILE_BACKEND;
$nj_collection_lang_file	= 'LLL:EXT:nj_collection/Resources/Private/Language/locallang_db.xlf:';

$nj_domain_model = 'ArtworkCat';
$nj_domain = strtolower($nj_domain_model);

return [
	'ctrl' => [
        'title' => $nj_ext_lang_file.'model.'.$nj_domain,
        'label' => 'name',
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
        'default_sortby' => 'ORDER BY name ASC',
        //'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'requestUpdate' => 'sys_language_uid,finished_training',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($nj_ext_path) . 'Resources/Public/Icons/' . $nj_ext_key . '_domain_model_' . $nj_domain . '.svg',
    ],
	'interface' => [
        'showRecordFieldList' => 'sorting',
		'maxDBListItems' => 100,
		'maxSingleDBListItems' => 500,
		'always_description' => 1,
    ],
	'feInterface' => [
        'fe_admin_fieldList' => 'title',
    ],
	'columns' => [
        'tstamp' => [
            'exclude' => 1,
            'label' => 'Creation date',
            'config' => [
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
            ],
        ],
		'sys_language_uid' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'change' => 'reload',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => [
					['LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1],
					['LLL:EXT:lang/locallang_general.php:LGL.default_value',0],
				],
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
        'l18n_diffsource' => [
            'config'=> [
                'type'=>'passthrough'
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config'  => [
                'type' => 'check'
            ],
        ],

		'name' => [
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.name',
			'config'  => [
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim,required',
				'max'  => 256
			],
		],
		'description' => [
			'exclude' => 0,
			'label'   => $nj_collection_lang_file.'label.general.description',
			'config'  => [
				'type' => 'text',
				'cols' => 60,
				'rows' => 6,
			],
			'defaultExtras' => 'richtext[]',
		],
    ],
	'types' => [
        '0' => ['showitem' => 'hidden,sys_language_uid;;1,name,description']
    ],
    'palettes' => [
        '1' => ['showitem' => 'l18n_parent']
    ],
];