<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Chancenportal.Chancenportal',
            'Chancenportal',
            'Chancenportal'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('chancenportal', 'Configuration/TypoScript', 'Chancenportal');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_chancenportal_domain_model_provider', 'EXT:chancenportal/Resources/Private/Language/locallang_csh_tx_chancenportal_domain_model_provider.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_chancenportal_domain_model_provider');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_chancenportal_domain_model_offer', 'EXT:chancenportal/Resources/Private/Language/locallang_csh_tx_chancenportal_domain_model_offer.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_chancenportal_domain_model_offer');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_chancenportal_domain_model_label', 'EXT:chancenportal/Resources/Private/Language/locallang_csh_tx_chancenportal_domain_model_label.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_chancenportal_domain_model_label');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_chancenportal_domain_model_date', 'EXT:chancenportal/Resources/Private/Language/locallang_csh_tx_chancenportal_domain_model_date.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_chancenportal_domain_model_date');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_chancenportal_domain_model_carrier', 'EXT:chancenportal/Resources/Private/Language/locallang_csh_tx_chancenportal_domain_model_carrier.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_chancenportal_domain_model_carrier');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_chancenportal_domain_model_category', 'EXT:chancenportal/Resources/Private/Language/locallang_csh_tx_chancenportal_domain_model_category.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_chancenportal_domain_model_category');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_chancenportal_domain_model_targetgroup', 'EXT:chancenportal/Resources/Private/Language/locallang_csh_tx_chancenportal_domain_model_targetgroup.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_chancenportal_domain_model_targetgroup');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_chancenportal_domain_model_district', 'EXT:chancenportal/Resources/Private/Language/locallang_csh_tx_chancenportal_domain_model_district.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_chancenportal_domain_model_district');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_chancenportal_domain_model_log', 'EXT:chancenportal/Resources/Private/Language/locallang_csh_tx_chancenportal_domain_model_log.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_chancenportal_domain_model_log');

    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['chancenportal_chancenportal'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['chancenportal_chancenportal'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('chancenportal_chancenportal', 'FILE:EXT:chancenportal/Configuration/FlexForms/Frontend.xml');
