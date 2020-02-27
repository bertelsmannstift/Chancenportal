<?php
namespace UI\UiProvider\Backend\View;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class BackendLayoutView
 * @package UI\UiProvider\Backend\View
 *
 * This class extends the TYPO3 core class "BackendLayoutView" and replaces the function "addBackendLayoutItems" to
 * provide a functionality that respects the TSconfig TCEFORM.pages.backend_layout.keepItems for items that are added
 * to the backend_layout select via the itemsProcFunc "addBackendLayoutItems". Add the following to TCA Overrides to
 * use this feature:
 *
 *      $GLOBALS['TCA']['pages']['columns']['backend_layout']['config']['itemsProcFunc'] =
 *      \UI\UiProvider\Backend\View\BackendLayoutView::class . '->addBackendLayoutItems';
 */
class BackendLayoutView extends \TYPO3\CMS\Backend\View\BackendLayoutView
{
    /**
     * Gets backend layout items to be shown in the forms engine.
     * This method is called as "itemsProcFunc" with the accordant context
     * for pages.backend_layout and pages.backend_layout_next_level.
     *
     * Added by u+i: $identifiersToBeKept functionality
     *
     * @param array $parameters
     */
    public function addBackendLayoutItems(array $parameters)
    {
        $pageId = $this->determinePageId($parameters['table'], $parameters['row']);
        $pageTsConfig = (array)BackendUtility::getPagesTSconfig($pageId);
        $identifiersToBeExcluded = $this->getIdentifiersToBeExcluded($pageTsConfig);
        $identifiersToBeKept = $this->getIdentifiersToBeKept($pageTsConfig, $parameters['field']);

        $dataProviderContext = $this->createDataProviderContext()
            ->setPageId($pageId)
            ->setData($parameters['row'])
            ->setTableName($parameters['table'])
            ->setFieldName($parameters['field'])
            ->setPageTsConfig($pageTsConfig);

        $backendLayoutCollections = $this->getDataProviderCollection()->getBackendLayoutCollections($dataProviderContext);
        foreach ($backendLayoutCollections as $backendLayoutCollection) {
            $combinedIdentifierPrefix = '';
            if ($backendLayoutCollection->getIdentifier() !== 'default') {
                $combinedIdentifierPrefix = $backendLayoutCollection->getIdentifier() . '__';
            }

            foreach ($backendLayoutCollection->getAll() as $backendLayout) {
                $combinedIdentifier = $combinedIdentifierPrefix . $backendLayout->getIdentifier();

                if (in_array($combinedIdentifier, $identifiersToBeExcluded, true)) {
                    continue;
                }

                if (count($identifiersToBeKept) === 0 || in_array($combinedIdentifier, $identifiersToBeKept, true)) {
                    $parameters['items'][] = [
                        $this->getLanguageService()->sL($backendLayout->getTitle()),
                        $combinedIdentifier,
                        $backendLayout->getIconPath(),
                    ];
                }

            }
        }
    }

    /**
     * Gets backend layout identifiers to be kept
     *
     * @param array $pageTSconfig
     * @param string $field
     * @return array
     */
    protected function getIdentifiersToBeKept(array $pageTSconfig, $field)
    {
        $identifiersToBeKept = [];

        if (ArrayUtility::isValidPath($pageTSconfig, 'TCEFORM./pages./'.$field.'./keepItems')) {
            $identifiersToBeKept = GeneralUtility::trimExplode(
                ',',
                ArrayUtility::getValueByPath($pageTSconfig, 'TCEFORM./pages./'.$field.'./keepItems'),
                true
            );
        }

        return $identifiersToBeKept;
    }
}
