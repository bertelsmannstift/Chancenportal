<?php
namespace UI\UiProvider\Service;

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

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CacheService
 * @package UI\UiProvider\Service
 */
class CacheService implements SingletonInterface
{
    /**
     * Holds the cache manager
     *
     * @var \TYPO3\CMS\Core\Cache\CacheManager
     */
    protected $cacheManager;

    /**
     * Settings
     */
    protected $settings = [];

    /**
     * FlashMessageService constructor
     */
    public function __construct()
    {
        $this->cacheManager = GeneralUtility::makeInstance(CacheManager::class);
    }

    /**
     * Helper function to retrieve an item from the cache or, if not present, add it to the cache
     *
     * @param $cacheIdentifier
     * @param $cacheEntryIdentifier
     * @param callable $cacheSetFunction
     * @param array $cacheSetFunctionParameters
     * @param array $cacheTags
     * @param null $cacheLifetime
     * @param bool $cacheEmptyValues
     * @return mixed|\TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     *
     * Usage
     * -----
     *
     * // Create Cache in ext_localconf.php (VariableFrontend, Typo3DatabaseBackend). Remember to update DB after adding configuration.
     * // https://docs.typo3.org/m/typo3/reference-coreapi/master/en-us/ApiOverview/CachingFramework/Index.html
     * if (empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['CacheIdentifier'])) {
     *      $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['CacheIdentifier'] = [];
     * }
     *
     * // In your Extension use:
     * $cacheService = GeneralUtility::makeInstance(CacheService::class);
     * $value = $cacheService->getFromCacheOrSet('CacheIdentifier', 'CacheEntryIdentifier', function($param1) {
     *      // Do something that would be better off in the cache
     *      $return = $param1 . ' Lorem Ipsum';
     *
     *      return $return;
     * }, ['Value for $param1'], ['CacheTag1', 'CacheTag2'], 3600);
     */
    public function getFromCacheOrSet($cacheIdentifier, $cacheEntryIdentifier, callable $cacheSetFunction, $cacheSetFunctionParameters = [], $cacheTags = [], $cacheLifetime = null, $cacheEmptyValues = false) {
        if(!is_null($cacheLifetime)) {
            $cacheLifetime = intval($cacheLifetime);
        }

        $cache = $this->cacheManager->getCache($cacheIdentifier);

        if($cache->has($cacheEntryIdentifier)) {
            return $cache->get($cacheEntryIdentifier);
        } else {
            $cacheValue = call_user_func_array($cacheSetFunction, $cacheSetFunctionParameters);

            if($cacheEmptyValues || !empty($cacheValue)) {
                $cache->set($cacheEntryIdentifier, $cacheValue, $cacheTags, $cacheLifetime);
            }

            return $cacheValue;
        }
    }
}
