<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
use N1coode\NjArtgallery\Service\Constants as Constants;

$nj_ext_key			= Constants::NJ_EXT_KEY;
$nj_ext_namespace	= Constants::NJ_EXT_NAMESPACE;
$nj_ext_path		= Constants::NJ_EXT_PATH;
$nj_ext_title		= Constants::NJ_EXT_TITLE;

$nj_ext_lang_file			= Constants::NJ_EXT_LANG_FILE_BACKEND;
$nj_collection_lang_file	= 'LLL:EXT:nj_collection/Resources/Private/Language/locallang_db.xlf:';

$nj_domain_model = 'Artwork';
$nj_domain = strtolower($nj_domain_model);

return array(
	'ctrl' => array(
        'title' => $nj_ext_lang_file.'model.'.$nj_domain,
        'label' => 'title',
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
        'default_sortby' => 'ORDER BY title ASC',
        //'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden'
        ),
        'requestUpdate' => 'sys_language_uid,on_sale',
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
		'artist' => Array (
			'exclude' => 0,
            'displayCond' => 'FIELD:sys_language_uid:<=:0',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'hideDiff,defaultAsReadonly',
            'label'   => $nj_ext_lang_file.'label.general.artists',
            'config' => Array (
                'type' => 'select',
                'foreign_table' => $nj_extkey.'_domain_model_artist',
				'foreign_table_where' => 'AND '.$nj_extkey.'_domain_model_artist.pid=###CURRENT_PID### ORDER BY '.$nj_extkey.'_domain_model_artist.last_name',
				'renderType' => 'selectSingle',
				'size' => 15,
				'multiple' => 0,
				'minitems' => 0,
				'maxitems' => 1,
			),
        ),
		'category' => array(
            'exclude' => 0,
            'label' => $nj_collection_lang_file.'label.general.category',
            'config' => array(
                'type' 	=> 'select',
                'foreign_table'         => $nj_extkey.'_domain_model_artworkcat',
                'foreign_table_where' 	=> 'ORDER BY '.$nj_extkey.'_domain_model_artworkcat.name',
                'size'                  => 5,
                'maxitems'              => 10,
				'minitems'				=> 0
            )
        ),
		'cryear' => Array (
            'exclude' => 0,
            'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.creationYear',
            'config' => Array (
                'type' => 'input',
                'size' => 10,
                'eval' => 'int',
            )
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
		'height' => Array (
            'exclude' => 0,
            'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.height',
            'config' => Array (
                'type'  => 'input',
                'size'  => 10,
                'eval'  => 'int',
            )
        ),
		'image' => array(
            'exclude' => 0,
            'label' => $nj_collection_lang_file.'label.general.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('image', array(
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
                'minitems' => 0,
                'maxitems' => 1,
            ),
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
        ),
		'media' => array(
            'exclude' => 0,
            'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.media',
            'config' => array(
                'type'                  => 'select',
                'foreign_table'         => $nj_extkey.'_domain_model_artworkmedium',
                'foreign_table_where' 	=> 'ORDER BY '.$nj_extkey.'_domain_model_artworkmedium.title',
                'size'                  => 5,
                'maxitems'              => 5,
				'minitems'				=> 0
            )
        ),
        'motives' => array(
            'exclude' => 0,
            'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.motives',
            'config' => array(
                'type'                  => 'select',
                'foreign_table'         => $nj_extkey.'_domain_model_artworkmotive',
                'foreign_table_where'   => 'ORDER BY '.$nj_extkey.'_domain_model_artworkmotive.title',
                'size'                  => 5,
                'maxitems'              => 5,
				'minitems'				=> 0
            )
        ),
		'on_sale' => array(
            'exclude' => 0,
            'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.onSale',
            'change' => 'reload',
            'config' => array(
                'type'      => 'check',
                'default'   => 0
            )
        ),
		'showcase' => array(
            'exclude' => 0,
            'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.showcase',
            'config' => array(
                'type'      => 'check',
                'default'   => 0
            )
        ),
        'sold' => array(
            'exclude' => 0,
            'displayCond' => 'FIELD:on_sale:>:0',
            'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.sold',
            'config' => array(
                'type' => 'check',
            ) 
        ),
		'techniques' => array(
            'exclude' => 0,
            'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.usedTechniques',
            'config' => array(
                'type'                  => 'select',
                'foreign_table'         => $nj_extkey.'_domain_model_artworktech',
                'foreign_table_where' 	=> 'ORDER BY '.$nj_extkey.'_domain_model_artworktech.name',
                'size'                  => 5,
                'maxitems'              => 5,
				'minitems'				=> 0
            )
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
		'width' => Array (
            'exclude' => 0,
            'label' => $nj_ext_lang_file.'label.model.'.$nj_domain.'.width',
            'config' => Array (
                'type'  => 'input',
                'size'  => 10,
                'eval'  => 'int',
            )
        ),
		
    ),
	'types' => array(
        '0' => array('showitem' => 
			  '--div--;'.$nj_ext_lang_file.'tab.generalInformation,hidden,sys_language_uid;;1,title,cryear,artist,description,showcase,on_sale,sold,'
			. '--div--;'.$nj_ext_lang_file.'tab.categorization,category,motives,media,techniques,--palette--;'.$nj_ext_lang_file.'label.model.'.$nj_domain.'.dimensions;nj_artgallery_artist_dimensions,'
			. '--div--;'.$nj_collection_lang_file.'tab.general.images,image' )
    ),
    'palettes' => array(
        '1' => array('showitem' => 'l18n_parent'),
		'nj_artgallery_artist_dimensions' => array(
            'showitem'          => 'width, height,',
            'canNotCollapse'    => '1',
        )
    ),
);