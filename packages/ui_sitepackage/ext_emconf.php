<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'u+i Sitepackage',
	'description' => 'Project specific Configuration',
	'category' => 'be',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '8.7.0-8.9.99',
            'ui_provider' => '',
		),
		'conflicts' => array(),
		'suggests' => array(),
	),
);
