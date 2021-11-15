<?php

namespace Chancenportal\Chancenportal\ViewHelper;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class PaginationViewHelper
 */
class PaginationViewHelper extends AbstractViewHelper
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
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('totalItems', 'integer', 'Total number of items to paginate', true);
        $this->registerArgument('itemsOffset', 'integer', 'Offset of the items on the current page', false, 0);
        $this->registerArgument('itemsPerPage', 'integer', 'Number of items per paginated page', false, 10);
        $this->registerArgument('maxPaginationLinks', 'integer', 'Max. number of links in pagination', false, 10);
        $this->registerArgument('linkConfiguration', 'array', 'Link configuration', false, []);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return mixed the parsed data
     */
    public function render()
    {
        $this->totalItems = $this->arguments['totalItems'];
        $this->itemsOffset = $this->arguments['itemsOffset'];
        $this->itemsPerPage = $this->arguments['itemsPerPage'];
        $this->maxPaginationLinks = $this->arguments['maxPaginationLinks'];

        $this->currentPage = intval($this->itemsOffset / $this->itemsPerPage + 1);
        $this->numberOfPages = $this->itemsPerPage > 0 ? ceil($this->totalItems / $this->itemsPerPage) : 0;

        ArrayUtility::mergeRecursiveWithOverrule($this->linkConfiguration, $this->arguments['linkConfiguration']);

        return $this->buildPagination();
    }

    /**
     * Returns an array with the keys "pages", "current", "numberOfPages",
     * "nextPage" & "previousPage"
     *
     * @return array
     */
    protected function buildPagination(): array
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
