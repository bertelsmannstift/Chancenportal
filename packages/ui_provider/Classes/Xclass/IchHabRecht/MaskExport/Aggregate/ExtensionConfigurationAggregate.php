<?php
namespace UI\UiProvider\Xclass\IchHabRecht\MaskExport\Aggregate;

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

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use UI\UiProvider\Service\MaskJsonService;

/**
 * Class ExtensionConfigurationAggregate
 * @package UI\UiProvider\Xclass\IchHabRecht\MaskExport\Aggregate
 *
 * Allow generation of split mask.json files
 */
class ExtensionConfigurationAggregate extends \IchHabRecht\MaskExport\Aggregate\ExtensionConfigurationAggregate
{
    /**
     * Adds mask.json configuration file(s)
     */
    protected function addMaskConfiguration()
    {
        $maskExportConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('mask_export');

        if($maskExportConfiguration['split_json'] === true) {
            $modules = MaskJsonService::getInstance()->extractModules($this->maskConfiguration);

            foreach ($modules as $key => $data) {
                $content = json_encode($data, JSON_PRETTY_PRINT);
                $this->addPlainTextFile(
                    $this->escapeMaskExtensionKey('Configuration/Mask/' . $key . '.json'),
                    $this->escapeMaskExtensionKey($content)
                );
            }
        } else {
            $content = json_encode($this->maskConfiguration, JSON_PRETTY_PRINT);
            $this->addPlainTextFile(
                $this->escapeMaskExtensionKey('Configuration/Mask/mask.json'),
                $this->escapeMaskExtensionKey($content)
            );
        }
    }
}