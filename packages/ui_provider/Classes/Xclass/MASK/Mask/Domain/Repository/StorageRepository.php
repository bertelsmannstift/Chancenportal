<?php
namespace UI\UiProvider\Xclass\MASK\Mask\Domain\Repository;

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

use TYPO3\CMS\Core\Core\Environment;
use UI\UiProvider\Service\MaskJsonService;

/**
 * Class StorageRepository
 * @package UI\UiProvider\Xclass\MASK\Mask\Domain\Repository
 *
 * Use the MaskJsonService to load the mask configuration. This allows for split mask config json files.
 */
class StorageRepository extends \MASK\Mask\Domain\Repository\StorageRepository
{
    /**
     * Load Storage
     *
     * @return array
     * @throws \TYPO3\CMS\Core\Exception
     */
    public function load(): array
    {
        return MaskJsonService::getInstance()->getConfiguration(Environment::getPublicPath() . '/' . $this->extSettings["json"]);
    }

    /**
     * Write Storage
     */
    public function write($json): void
    {
        MaskJsonService::getInstance()->saveConfiguration(Environment::getPublicPath() . '/' . $this->extSettings["json"], $json);
    }
}