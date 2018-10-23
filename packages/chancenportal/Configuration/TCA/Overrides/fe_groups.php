<?php
defined('TYPO3_MODE') || die();

if (!isset($GLOBALS['TCA']['fe_groups']['ctrl']['type'])) {
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['fe_groups']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_chancenportal_fe_groups = [];
    $tempColumnstx_chancenportal_fe_groups[$GLOBALS['TCA']['fe_groups']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['',''],
                ['FrontendUserGroup','Tx_Chancenportal_FrontendUserGroup']
            ],
            'default' => 'Tx_Chancenportal_FrontendUserGroup',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_groups', $tempColumnstx_chancenportal_fe_groups);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_groups',
    $GLOBALS['TCA']['fe_groups']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['fe_groups']['ctrl']['label']
);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_groups']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['fe_groups']['types']['Tx_Chancenportal_FrontendUserGroup']['showitem'] = $GLOBALS['TCA']['fe_groups']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_groups']['types'])) {
    // use first entry in types array
    $fe_groups_type_definition = reset($GLOBALS['TCA']['fe_groups']['types']);
    $GLOBALS['TCA']['fe_groups']['types']['Tx_Chancenportal_FrontendUserGroup']['showitem'] = $fe_groups_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_groups']['types']['Tx_Chancenportal_FrontendUserGroup']['showitem'] = '';
}
$GLOBALS['TCA']['fe_groups']['types']['Tx_Chancenportal_FrontendUserGroup']['showitem'] .= ',--div--;LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_frontendusergroup,';
$GLOBALS['TCA']['fe_groups']['types']['Tx_Chancenportal_FrontendUserGroup']['showitem'] .= '';

$GLOBALS['TCA']['fe_groups']['columns'][$GLOBALS['TCA']['fe_groups']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:fe_groups.tx_extbase_type.Tx_Chancenportal_FrontendUserGroup','Tx_Chancenportal_FrontendUserGroup'];
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder