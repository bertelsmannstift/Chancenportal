<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\FluidTYPO3\Flux\Core::registerProviderExtensionKey('Ui.UiGrid', 'Content');

/**
 * Default PageTsConfig
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="DIR:EXT:ui_grid/Configuration/PageTSconfig/" extensions="typoscript">');

/**
 * Register "18181" as a valid colPos for nested content
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\UI\UiGrid\Form\FormDataProvider\TcaColPosItem::class] = [
    'depends' => [
        \TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowDefaultValues::class,
    ],
    'before' => [
        \TYPO3\CMS\Backend\Form\FormDataProvider\TcaSelectItems::class,
    ],
];

/**
 * This XCLASS provides a function that is used to keep Items with "colPos" 18181 in the Columns array.
 * The default function would discard it, since 18181 is not defined in the BE Layout.
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Backend\\View\\BackendLayoutView'] = array(
    'className' => 'UI\\UiGrid\\Xclass\\Backend\\View\\BackendLayoutView'
);
