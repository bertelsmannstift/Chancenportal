<?php

namespace Chancenportal\Chancenportal\Utility;

use Chancenportal\Chancenportal\Domain\Repository\UserGroupRepository;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class AbstractUtility
 */
abstract class AbstractUtility
{
    /**
     * Get table configuration array for a defined table
     *
     * @param string $table
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getTcaFromTable($table = 'fe_users')
    {
        $tca = [];
        if (!empty($GLOBALS['TCA'][$table])) {
            $tca = $GLOBALS['TCA'][$table];
        }
        return $tca;
    }

    /**
     * Get table configuration array for a defined table
     *
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function getSettings()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        return $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
    }

    /**
     * @return array|null
     */
    public static function getPermissions()
    {
        $settings = self::getSettings();
        return array_flip($settings['chancenportal']['permissions']);
    }

    /**
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getFilesArray()
    {
        return (array)$_FILES;
    }

    /**
     * @return UserGroupRepository
     */
    protected static function getUserGroupRepository()
    {
        return self::getObjectManager()->get(UserGroupRepository::class);
    }

    /**
     * @return TypoScriptFrontendController
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }

    /**
     * Get TYPO3 encryption key
     *
     * @return string
     * @throws \Exception
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getEncryptionKey()
    {
        if (empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'])) {
            throw new \UnexpectedValueException('No encryption key found in this TYPO3 installation', 1516373945265);
        }
        return $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'];
    }

    /**
     * Get extension configuration from LocalConfiguration.php
     *
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getExtensionConfiguration(): array
    {
        $configuration = [];
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['femanager'])) {
            $configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['femanager']);
        }
        return $configuration;
    }

    /**
     * @return ContentObjectRenderer
     */
    protected static function getContentObject()
    {
        return self::getObjectManager()->get(ContentObjectRenderer::class);
    }

    /**
     * @return ConfigurationManagerInterface
     */
    protected static function getConfigurationManager()
    {
        return self::getObjectManager()->get(ConfigurationManagerInterface::class);
    }

    /**
     * @return ObjectManagerInterface
     */
    protected static function getObjectManager()
    {
        return GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * @param $title
     * @param $table
     * @return string
     */
    public static function generateSlug($title, $table)
    {
        $title = preg_replace('/\//is', '-', $title);
        $fieldName = 'slug';
        $fieldConfig = $GLOBALS['TCA'][$table]['columns'][$fieldName]['config'];
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, $table, $fieldName, $fieldConfig);
        return $slugHelper->sanitize('/' . $title);
    }
}
