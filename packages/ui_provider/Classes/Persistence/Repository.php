<?php
namespace UI\UiProvider\Persistence;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class Repository
 * @package UI\UiProvider\Persistence
 */
class Repository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Create query and apply constraints and query settings.
     *
     * @param $constraints
     * @param array $extendedConstraints
     * @return array
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     *
     * Returns
     * -------
     * [
     *     'query' => \TYPO3\CMS\Extbase\Persistence\QueryInterface,
     *     'constraints' => array,
     *     'queryConstraints' => array
     * ]
     */
    public function createQueryAndApplyGeneralConstraintsAndQuerySettings($constraints, $extendedConstraints = [])
    {
        $query = $this->createQuery();

        /** Merge default constraints  with parameters */
        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($constraints, $extendedConstraints);

        $_constraints = [];

        /** UID */
        if (isset($constraints['uid']) && count($constraints['uid']) > 0) {
            $uids = $constraints['uid'];

            /**
             * Behave like findByUid() and return all items regardless of current language.
             * Apply language_overlay if possible
             */
            $this->behaveLikeFindByUid($query);

            /**
             * Return only translated records. Otherwise default language items that match the 'uid' constraint
             * are returned as well
             */
            if($constraints['_getOnlyTranslatedRecords'] === true) {
                $uids = $this->filterNonTranslatedUids($this, $constraints['uid']);
            }

            $_constraints[] = $query->in('uid', (array) $uids);
        }

        /** Set storage pids */
        if (is_array($constraints['_persistence'])) {
            $this->setQueryStoragePids($query, $constraints['_persistence']);
        }

        /** Set ignore enable fields */
        if (isset($constraints['_ignoreEnableFields'])) {
            $this->ignoreEnableFields($query, (boolean)$constraints['_ignoreEnableFields']);
        }

        /** Limit */
        if (isset($constraints['limit']) && intval($constraints['limit']) > 0) {
            $query->setLimit((int) $constraints['limit']);
        }

        /** Offset */
        if (isset($constraints['offset']) && intval($constraints['offset']) > 0) {
            $query->setOffset((int) $constraints['offset']);
        }

        /**
         * Set Orderings
         */
        if (!empty($constraints['orderings']) && is_array($constraints['orderings'])) {
            $query->setOrderings($constraints['orderings']);
        }

        return [
            'query' => $query,
            'constraints' => $constraints,
            'queryConstraints' => $_constraints
        ];
    }

    /**
     * Execute query
     *
     * @param $query
     * @return object
     */
    public function executeQuery($query)
    {
        if (!empty($query['queryConstraints'])) {
            $query['query']->matching($query['query']->logicalAnd($query['queryConstraints']));
        }

        $result = $query['query']->execute();

        if (!empty($query['constraints']['_getFirst']) && $result instanceof QueryResultInterface) {
            return $result->getFirst();
        }

        return $result;
    }

    /**
     * Set the storage PID based on the TypoScript settings. Called by the Repository initializeObject method.
     *
     * TypoScript Format example:
     *
     * config.tx_extbase.settings {
     *     extensionKey {
     *         persistence {
     *             pluginName {
     *                 storagePid =
     *                 recursive =
     *             }
     *         }
     *     }
     * }
     *
     * @param string $extensionKey
     * @param string $pluginName
     */
    public function setDefaultStoragePids($extensionKey = '', $pluginName = '') {
        if(!empty($extensionKey) && !empty($pluginName)) {
            if(TYPO3_MODE === 'FE') {
                $defaultStoragePid = $this->createQuery()->getQuerySettings()->getStoragePageIds();

                if(count($defaultStoragePid) === 1 && $defaultStoragePid[0] === 0) {
                    $this->setDefaultQuerySettings(
                        $this->getQuerySettingsWithUpdatedStoragePids(
                            $GLOBALS['TSFE']->config['config']['tx_extbase.']['settings.'][$extensionKey.'.']['persistence.'][$pluginName.'.']
                        )
                    );
                }
            }
            else if(TYPO3_MODE === 'BE') {
                $this->setDefaultQuerySettings(
                    $this->getQuerySettingsWithUpdatedStoragePids([
                        'storagePid' => []
                    ])
                );
            }
        }
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param $persistenceSettings
     */
    public function setQueryStoragePids($query, $persistenceSettings)
    {
        $query->setQuerySettings(
            $this->getQuerySettingsWithUpdatedStoragePids($persistenceSettings)
        );
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param bool $ignore
     */
    public function ignoreEnableFields($query, $ignore = true)
    {
        $querySettings = $query->getQuerySettings();
        $querySettings->setIgnoreEnableFields($ignore);
        $query->setQuerySettings($querySettings);
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     */
    public function behaveLikeFindByUid($query)
    {
        if(TYPO3_MODE === 'FE') {
            $querySettings = $query->getQuerySettings();
            $querySettings->setLanguageOverlayMode(true);
            $querySettings->setRespectSysLanguage(false);
            $query->setQuerySettings($querySettings);
        }
    }

    /**
     * @param $repository
     * @param $uids
     * @return array
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public function filterNonTranslatedUids($repository, $uids)
    {
        if(TYPO3_MODE === 'FE') {
            /**
             * Get all records that match the 'uid' constraint, including default language items if no translation exists
             */
            $result = $repository->find(['uid' => $uids]);

            /** Get current language uid */
            $currentLanguageUid = GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('language', 'id');

            /**
             * Filter non-translated items
             */
            $uids = [];
            foreach ($result as $item) {
                if ($currentLanguageUid === $item->_getProperty('_languageUid')) {
                    $uids[] = $item->getUid();
                }
            }
        }

        return $uids;
    }

    /**
     * @param null $storagePids
     * @return int|mixed
     */
    public function getFirstStoragePid($storagePids = null)
    {
        if(!is_null($storagePids)) {
            if(is_string($storagePids)) {
                $storagePids = GeneralUtility::intExplode(',', $storagePids, true);
            }
        } else {
            $storagePids = $this->createQuery()->getQuerySettings()->getStoragePageIds();
        }

        if(is_array($storagePids) && count($storagePids) > 0) {
            return $storagePids[0];
        }

        return 0;
    }

    /**
     * @param $persistenceSettings
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface
     */
    private function getQuerySettingsWithUpdatedStoragePids($persistenceSettings)
    {
        $querySettings = $this->createQuery()->getQuerySettings();

        if(isset($persistenceSettings['storagePid'])) {
            if(empty($persistenceSettings['storagePid'])) {
                $querySettings->setRespectStoragePage(false);
            } else {
                $querySettings->setRespectStoragePage(true);
                $querySettings->setStoragePageIds($this->expandStoragePids($persistenceSettings));
            }
        }

        return $querySettings;
    }

    /**
     * @param $persistenceSettings
     * @return array
     */
    private function expandStoragePids($persistenceSettings)
    {
        $storagePids = [];

        if(!empty($persistenceSettings['storagePid'])) {
            if(is_string($persistenceSettings['storagePid']) || is_integer($persistenceSettings['storagePid'])) {
                $persistenceSettings['storagePid'] = GeneralUtility::intExplode(',', $persistenceSettings['storagePid'], true);
            }

            $persistenceSettings['recursive'] = intval($persistenceSettings['recursive']);

            $queryGenerator = GeneralUtility::makeInstance(QueryGenerator::class);
            foreach($persistenceSettings['storagePid'] as $pid) {
                $ids = $queryGenerator->getTreeList($pid, $persistenceSettings['recursive'], 0, 'hidden = 0');
                $storagePids = array_merge($storagePids, GeneralUtility::intExplode(',', $ids, true));
            }
        }

        return $storagePids;
    }
}