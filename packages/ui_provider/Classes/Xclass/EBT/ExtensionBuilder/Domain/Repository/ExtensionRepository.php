<?php
namespace UI\UiProvider\Xclass\EBT\ExtensionBuilder\Domain\Repository;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use EBT\ExtensionBuilder\Configuration\ExtensionBuilderConfigurationManager;
use EBT\ExtensionBuilder\Domain\Model\Extension;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ExtensionRepository
 * @package UI\UiProvider\Xclass\EBT\ExtensionBuilder\Domain\Repository
 *
 * Adjust file paths for Layouts and Templates. These are "Namespaced" in the u+i Blueprint Naming scheme!
 */
class ExtensionRepository extends \EBT\ExtensionBuilder\Domain\Repository\ExtensionRepository
{
    /**
     * @param \EBT\ExtensionBuilder\Domain\Model\Extension $extension
     *
     * @throws \Exception
     * @throws \TYPO3\CMS\Core\Package\Exception
     */
    public function saveExtensionConfiguration(Extension $extension): void
    {
        $extensionBuildConfiguration = $this->configurationManager->getConfigurationFromModeler();
        $extensionBuildConfiguration['log'] = [
            'last_modified' => date('Y-m-d h:i'),
            'extension_builder_version' => ExtensionManagementUtility::getExtensionVersion('extension_builder'),
            'be_user' => $GLOBALS['BE_USER']->user['realName'] . ' (' . $GLOBALS['BE_USER']->user['uid'] . ')'
        ];
        $encodeOptions = 0;
        // option JSON_PRETTY_PRINT is available since PHP 5.4.0
        if (defined('JSON_PRETTY_PRINT')) {
            $encodeOptions |= JSON_PRETTY_PRINT;
        }
        GeneralUtility::writeFile($extension->getExtensionDir() . ExtensionBuilderConfigurationManager::EXTENSION_BUILDER_SETTINGS_FILE, json_encode($extensionBuildConfiguration, $encodeOptions));

        /** Adjust file paths for Layouts and Templates */
        if($extension->getSettings()['uandi']['templatePaths'] === 'namespaced') {
            $this->adjustFluidFilepaths($extension);
        }
    }

    /**
     * Adjust file paths for Layouts and Templates. These are "Namespaced" in the u+i Blueprint Naming scheme!
     *
     * @param Extension $extension
     * @throws \Exception
     *
     * Examples for "Namespaced" paths:
     * - Resources/Private/Layouts/UiLoremIpsum/View
     * - Resources/Private/Templates/UiLoremIpsum/View/Pluginname
     */
    private function adjustFluidFilepaths(Extension $extension)
    {
        $extensionKeyUCC = str_replace('_', '', ucwords($extension->getExtensionKey(), '_'));

        $layoutDirectory = $extension->getExtensionDir() . 'Resources/Private/Layouts/';
        $layoutDirectoryTarget = $extension->getExtensionDir() . 'Resources/Private/Layouts/' . $extensionKeyUCC . '/View/';
        $templateDirectory = $extension->getExtensionDir() . 'Resources/Private/Templates/';
        $templateDirectoryTarget = $extension->getExtensionDir() . 'Resources/Private/Templates/' . $extensionKeyUCC . '/View/';
        $partialDirectory = $extension->getExtensionDir() . 'Resources/Private/Partials/';
        $partialDirectoryTarget = $extension->getExtensionDir() . 'Resources/Private/Partials/' . $extensionKeyUCC . '/View/';

        GeneralUtility::mkdir_deep($layoutDirectoryTarget);
        GeneralUtility::mkdir_deep($templateDirectoryTarget);
        GeneralUtility::mkdir_deep($partialDirectoryTarget);

        /**
         * Move files from "Resources/Private/Layouts" to "Resources/Private/Layouts/XYZ/View"
         */
        foreach(array_diff(scandir($layoutDirectory), ['.', '..']) as $layoutFile) {
            if(file_exists($layoutDirectoryTarget . $layoutFile)) {
                unlink($layoutDirectory . $layoutFile);
            } else {
                if(strpos($layoutDirectoryTarget . $layoutFile, $layoutDirectory . $layoutFile) !== 0) {
                    rename($layoutDirectory . $layoutFile, $layoutDirectoryTarget . $layoutFile);
                }
            }
        }

        /**
         * Move files from "Resources/Private/Partials/ABC" to "Resources/Private/Partials/XYZ/View/ABC"
         */
        foreach(array_diff(scandir($partialDirectory), ['.', '..']) as $partialSubdirectory) {
            /** Directory "Resources/Private/Partials/XYZ/View/ABC" already exists */
            if(is_dir($partialDirectoryTarget . $partialSubdirectory)) {

                /** Loop all files in "Resources/Private/Partials/ABC" */
                foreach(array_diff(scandir($partialDirectory . $partialSubdirectory), ['.', '..']) as $partialFile) {

                    /** File does not exist in "Resources/Private/Partials/XYZ/View/ABC" */
                    if(!file_exists($partialDirectoryTarget . $partialSubdirectory . '/' . $partialFile)) {
                        /** Move file to "Resources/Private/Partials/XYZ/View/ABC" */
                        rename($partialDirectory . $partialSubdirectory . '/' . $partialFile, $partialDirectoryTarget . $partialSubdirectory . '/' . $partialFile);

                        /** Adjust layout path in file */
                        $str = file_get_contents($partialDirectoryTarget . $partialSubdirectory . '/' . $partialFile);
                        $str = str_replace('<f:layout name="', '<f:layout name="' . $extensionKeyUCC . '/View/', $str);
                        file_put_contents($partialDirectoryTarget . $partialSubdirectory . '/' . $partialFile, $str);
                    }
                }

                /** Remove directory "Resources/Private/Partials/ABC" */
                GeneralUtility::rmdir($partialDirectory . $partialSubdirectory, true);
            }

            /** Directory "Resources/Private/Partials/XYZ/View/ABC" does not exists */
            else {
                /** Move directory "Resources/Private/Partials/ABC" to "Resources/Private/Partials/XYZ/View/ABC" */
                if(strpos($partialDirectoryTarget . $partialSubdirectory, $partialDirectory . $partialSubdirectory) !== 0) {
                    rename($partialDirectory . $partialSubdirectory, $partialDirectoryTarget . $partialSubdirectory);
                }

                /** Loop all files in "Resources/Private/Partials/XYZ/View/ABC" and adjust layout path in file */
                if(is_dir($partialDirectoryTarget . $partialSubdirectory)) {
                    foreach(array_diff(scandir($partialDirectoryTarget . $partialSubdirectory), ['.', '..']) as $partialFile) {
                        $str = file_get_contents($partialDirectoryTarget . $partialSubdirectory . '/' . $partialFile);
                        $str = str_replace('<f:layout name="', '<f:layout name="' . $extensionKeyUCC . '/View/', $str);
                        file_put_contents($partialDirectoryTarget . $partialSubdirectory . '/' . $partialFile, $str);
                    }
                }
            }
        }

        /**
         * Move files from "Resources/Private/Templates/ABC" to "Resources/Private/Templates/XYZ/View/ABC"
         */
        foreach(array_diff(scandir($templateDirectory), ['.', '..']) as $templateSubdirectory) {
            /** Directory "Resources/Private/Templates/XYZ/View/ABC" already exists */
            if(is_dir($templateDirectoryTarget . $templateSubdirectory)) {

                /** Loop all files in "Resources/Private/Templates/ABC" */
                foreach(array_diff(scandir($templateDirectory . $templateSubdirectory), ['.', '..']) as $templateFile) {

                    /** File does not exist in "Resources/Private/Templates/XYZ/View/ABC" */
                    if(!file_exists($templateDirectoryTarget . $templateSubdirectory . '/' . $templateFile)) {
                        /** Move file to "Resources/Private/Templates/XYZ/View/ABC" */
                        rename($templateDirectory . $templateSubdirectory . '/' . $templateFile, $templateDirectoryTarget . $templateSubdirectory . '/' . $templateFile);

                        /** Adjust layout/partial path in file */
                        $str = file_get_contents($templateDirectoryTarget . $templateSubdirectory . '/' . $templateFile);
                        $str = str_replace('<f:layout name="', '<f:layout name="' . $extensionKeyUCC . '/View/', $str);
                        $str = str_replace('<f:render partial="', '<f:render partial="' . $extensionKeyUCC . '/View/', $str);
                        file_put_contents($templateDirectoryTarget . $templateSubdirectory . '/' . $templateFile, $str);
                    }
                }

                /** Remove directory "Resources/Private/Templates/ABC" */
                GeneralUtility::rmdir($templateDirectory . $templateSubdirectory, true);
            }

            /** Directory "Resources/Private/Templates/XYZ/View/ABC" does not exists */
            else {
                /** Move directory "Resources/Private/Templates/ABC" to "Resources/Private/Templates/XYZ/View/ABC" */
                if(strpos($templateDirectoryTarget . $templateSubdirectory, $templateDirectory . $templateSubdirectory) !== 0) {
                    rename($templateDirectory . $templateSubdirectory, $templateDirectoryTarget . $templateSubdirectory);
                }

                /** Loop all files in "Resources/Private/Templates/XYZ/View/ABC" and adjust layout/partial path in file */
                if(is_dir($templateDirectoryTarget . $templateSubdirectory)) {
                    foreach(array_diff(scandir($templateDirectoryTarget . $templateSubdirectory), ['.', '..']) as $templateFile) {
                        $str = file_get_contents($templateDirectoryTarget . $templateSubdirectory . '/' . $templateFile);
                        $str = str_replace('<f:layout name="', '<f:layout name="' . $extensionKeyUCC . '/View/', $str);
                        $str = str_replace('<f:render partial="', '<f:render partial="' . $extensionKeyUCC . '/View/', $str);
                        file_put_contents($templateDirectoryTarget . $templateSubdirectory . '/' . $templateFile, $str);
                    }
                }
            }
        }
    }
}