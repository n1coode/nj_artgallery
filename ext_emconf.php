<?php
/***************************************************************
 * Extension Manager/Repository config file for ext: "nj_artgallery
***************************************************************/
$nj_extkey = 'tx_njartgallery';
$nj_ext_title = 'njs Art Gallery';
$nj_ext_description = 'tba';
$nj_ext_version = '8.0.1';
$nj_ext_status = 'beta'; //stable, experimental

$EM_CONF[$_EXTKEY] = array(
	'title' => $nj_ext_title,
	'description' => $nj_ext_description,
	'category' => 'plugin',
	'author' => 'Nico Jatzkowski',
	'author_email' => 'nj@n1coo.de',
	'author_company' => 'n1coo.de',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => $nj_ext_status,
	'internal' => '',
	'uploadfolder' => '1',
	'createDirs' => 'uploads/'.$nj_extkey.',uploads/'.$nj_extkey.'/image',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'version' => $nj_ext_version,
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'extbase' => '6.2.0-0.0.0',
			'fluid' => '6.2.0-0.0.0',
			'typo3' => '6.2.0-0.0.0'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => '',
);
?>