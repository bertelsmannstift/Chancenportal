<?php
namespace UI\UiProvider\ViewHelpers\Widget\Controller;

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

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;

/**
 * Class PaginationController (Based on the PaginateController from the fluid core extension)
 *
 * @package UI\UiProvider\ViewHelpers\Widget\Controller
 */
class PaginationController extends AbstractWidgetController
{
    /**
     * @var int
     */
    protected $totalItems;

    /**
     * @var int
     */
    protected $itemsOffset;

    /**
     * @var int
     */
    protected $itemsPerPage;

    /**
     * @var int
     */
    protected $maxPaginationLinks;

    /**
     * @var array
     */
    protected $linkConfiguration = [
        'action' => null,
        'controller' => null,
        'extensionName' => null,
        'pluginName' => null
    ];

    /**
     * @var int
     */
    protected $currentPage = 1;

    /**
     * @var int
     */
    protected $numberOfPages = 1;

    /**
     * @var int
     */
    protected $displayRangeStart = null;

    /**
     * @var int
     */
    protected $displayRangeEnd = null;

    /**
     * Initializes the current information on which page the visitor is.
     */
    public function initializeAction()
    {
        $this->totalItems = $this->widgetConfiguration['totalItems'];
        $this->itemsOffset = $this->widgetConfiguration['itemsOffset'];
        $this->itemsPerPage = $this->widgetConfiguration['itemsPerPage'];
        $this->maxPaginationLinks = $this->widgetConfiguration['maxPaginationLinks'];

        $this->currentPage = intval($this->itemsOffset / $this->itemsPerPage + 1);
        $this->numberOfPages = $this->itemsPerPage > 0 ? ceil($this->totalItems / $this->itemsPerPage) : 0;

        ArrayUtility::mergeRecursiveWithOverrule($this->linkConfiguration, $this->widgetConfiguration['linkConfiguration']);
    }

    /**
     * @param int $currentPage
     */
    public function indexAction($currentPage = 1)
    {
        $this->view->assign('pagination', $this->buildPagination());
    }

    /**
     * Returns an array with the keys "pages", "current", "numberOfPages",
     * "nextPage" & "previousPage"
     *
     * @return array
     */
    protected function buildPagination()
    {
        $this->calculateDisplayRange();
        $pages = [];
        for ($i = $this->displayRangeStart; $i <= $this->displayRangeEnd; $i++) {
            $pages[] = [
                'number' => $i,
                'offset' => ($i - 1) * $this->itemsPerPage,
                'isCurrent' => $i === $this->currentPage
            ];
        }
        $pagination = [
            'linkConfiguration' => $this->linkConfiguration,
            'pages' => $pages,
            'current' => $this->currentPage,
            'numberOfPages' => $this->numberOfPages,
            'lastPageOffset' => ($this->numberOfPages - 1) * $this->itemsPerPage,
            'displayRangeStart' => $this->displayRangeStart,
            'displayRangeEnd' => $this->displayRangeEnd,
            'hasLessPages' => $this->displayRangeStart > 2,
            'hasMorePages' => $this->displayRangeEnd + 1 < $this->numberOfPages
        ];
        if ($this->currentPage < $this->numberOfPages) {
            $pagination['nextPage'] = $this->currentPage + 1;
            $pagination['nextPageOffset'] = $this->currentPage * $this->itemsPerPage;
        }
        if ($this->currentPage > 1) {
            $pagination['previousPage'] = $this->currentPage - 1;
            $pagination['previousPageOffset'] = ($this->currentPage - 2) * $this->itemsPerPage;
        }
        return $pagination;
    }

    /**
     * If a certain number of links should be displayed, adjust before and after
     * amounts accordingly.
     */
    protected function calculateDisplayRange()
    {
        $maximumNumberOfLinks = $this->maxPaginationLinks;
        if ($maximumNumberOfLinks > $this->numberOfPages) {
            $maximumNumberOfLinks = $this->numberOfPages;
        }
        $delta = floor($maximumNumberOfLinks / 2);
        $this->displayRangeStart = $this->currentPage - $delta;
        $this->displayRangeEnd = $this->currentPage + $delta - ($maximumNumberOfLinks % 2 === 0 ? 1 : 0);
        if ($this->displayRangeStart < 1) {
            $this->displayRangeEnd -= $this->displayRangeStart - 1;
        }
        if ($this->displayRangeEnd > $this->numberOfPages) {
            $this->displayRangeStart -= $this->displayRangeEnd - $this->numberOfPages;
        }
        $this->displayRangeStart = (int)max($this->displayRangeStart, 1);
        $this->displayRangeEnd = (int)min($this->displayRangeEnd, $this->numberOfPages);
    }
}
