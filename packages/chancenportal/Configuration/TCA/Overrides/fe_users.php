<?php
defined('TYPO3_MODE') || die();

if (!isset($GLOBALS['TCA']['fe_users']['ctrl']['type'])) {
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['fe_users']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_chancenportal_fe_users = [];
    $tempColumnstx_chancenportal_fe_users[$GLOBALS['TCA']['fe_users']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['',''],
                ['FrontendUser','Tx_Chancenportal_FrontendUser']
            ],
            'default' => 'Tx_Chancenportal_FrontendUser',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumnstx_chancenportal_fe_users);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    $GLOBALS['TCA']['fe_users']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['fe_users']['ctrl']['label']
);

$tmp_chancenportal_columns = [

    'password_reset_hash' => [
        'exclude' => true,
        'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_frontenduser.password_reset_hash',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'confirmation_send' => [
        'exclude' => true,
        'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_frontenduser.confirmation_send',
        'config' => [
            'type' => 'check',
            'items' => [
                '1' => [
                    '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                ]
            ],
            'default' => 0,
        ]
    ],
    'terms_and_conditions_date' => [
        'exclude' => true,
        'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_frontenduser.terms_and_conditions_date',
        'config' => [
            'dbType' => 'datetime',
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'size' => 12,
            'eval' => 'datetime',
            'default' => null,
        ],
    ],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_chancenportal_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_users']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['fe_users']['types']['Tx_Chancenportal_FrontendUser']['showitem'] = $GLOBALS['TCA']['fe_users']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_users']['types'])) {
    // use first entry in types array
    $fe_users_type_definition = reset($GLOBALS['TCA']['fe_users']['types']);
    $GLOBALS['TCA']['fe_users']['types']['Tx_Chancenportal_FrontendUser']['showitem'] = $fe_users_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_users']['types']['Tx_Chancenportal_FrontendUser']['showitem'] = '';
}
$GLOBALS['TCA']['fe_users']['types']['Tx_Chancenportal_FrontendUser']['showitem'] .= ',--div--;LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_frontenduser,';
$GLOBALS['TCA']['fe_users']['types']['Tx_Chancenportal_FrontendUser']['showitem'] .= 'password_reset_hash, confirmation_send, terms_and_conditions_date';

$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_Chancenportal_FrontendUser','Tx_Chancenportal_FrontendUser'];
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$GLOBALS['TCA']['fe_users']['columns']['crdate']['config'] = [
    'type' => 'passthrough',
];

$GLOBALS['TCA']['fe_users']['columns']['tstamp']['config'] = [
    'type' => 'passthrough',
];