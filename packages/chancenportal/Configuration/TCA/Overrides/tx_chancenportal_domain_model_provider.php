<?php

$GLOBALS['TCA']['tx_chancenportal_domain_model_provider']['columns']['participation']['config']['items'] = [
    ['Keine Angabe', 0],
    ['Erwünscht', 1],
    ['Möglich', 2],
    ['Nicht möglich', 3],
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_provider']['columns']['carrier']['config']['items'] = [
    ['Keine Angabe', 0]
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_provider']['columns']['contact_salutation']['config']['items'] = [
    ['Frau', 0],
    ['Herr', 1]
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_provider']['columns']['offers']['config']['appearance'] = [
    'collapseAll' => 1,
    'expandSingle' => 1,
];
$GLOBALS['TCA']['tx_chancenportal_domain_model_provider']['columns']['labels']['config']['appearance'] = [
    'collapseAll' => 1,
    'expandSingle' => 1,
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_provider']['columns']['tstamp']['config'] = [
    'type' => 'passthrough',
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_provider']['columns']['slug'] = [
    'exclude' => true,
    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:pages.slug',
    'config' => [
        'type' => 'slug',
        'size' => 50,
        'generatorOptions' => [
            'fields' => ['name'],
            'fieldSeparator' => '/',
            'prefixParentPageSlug' => true,
        ],
        'fallbackCharacter' => '-',
        'eval' => 'uniqueInSite',
        'default' => ''
    ]
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_provider']['columns']['tstamp']['config'] = [
    'type' => 'passthrough',
];
$GLOBALS['TCA']['tx_chancenportal_domain_model_provider']['columns']['crdate']['config'] = [
    'type' => 'passthrough',
];
