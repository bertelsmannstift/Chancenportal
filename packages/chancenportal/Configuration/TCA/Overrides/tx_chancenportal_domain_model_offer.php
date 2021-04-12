<?php

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['district']['config']['items'] = [
    ['Please select', 0],
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['access']['config']['items'] = [
    ['Keine Angabe', 1],
    ['Offen (ohne Mitgliedschaft)', 2],
    ['Mitgliedschaft erforderlich', 3],
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['accessibility']['config']['items'] = [
    ['Keine Angabe', 1],
    ['Ja', 2],
    ['Nein', 3],
];


$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['contact_salutation']['config']['items'] = [
    ['Frau', 0],
    ['Herr', 1]
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['date_type']['config']['items'] = [
    ['Ohne Termin', 0],
    ['Konkrete Daten', 1],
    ['Zeitraum', 2],
    ['Täglich', 3],
    ['Wöchentlich', 4],
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['address_type'] = array_replace_recursive($GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['address_type'], [
    'onChange' => 'reload',
    'config' => [
        'items' => [
            ['Angebot mit Adresse', 1],
            ['Angebot ohne Adresse (Z.B. Onlineangebot)', 2],
        ]
    ]
]);

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['address'] = array_replace_recursive($GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['address'], [
    'displayCond' => 'FIELD:address_type:!=:2',
]);

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['slug'] = [
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

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['categories']['config']['type'] = 'select';

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['tstamp']['config'] = [
    'type' => 'passthrough',
];
$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['crdate']['config'] = [
    'type' => 'passthrough',
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['dates']['config']['appearance']['collapseAll'] = 1;

$GLOBALS['TCA']['tx_chancenportal_domain_model_offer']['columns']['provider']['config']['foreign_table'] = 'tx_chancenportal_domain_model_provider';

