<?php
namespace UI\UiProvider\ViewHelpers\Widget;

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

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;

/**
 * Class PaginationViewHelper
 * @package UI\UiProvider\ViewHelpers\Widget
 *
 * Viewhelper to render a pagination based on information about a resultset like total number of items, items per page, etc.
 *
 * Usage
 * -----
 * <html xmlns:uandi="http://typo3.org/ns/UI/UiProvider/ViewHelpers" data-namespace-typo3-fluid="true">
 *     <uandi:widget.pagination totalItems="{ads.total}" itemsOffset="{ads.offset}" itemsPerPage="10" maxPaginationLinks="5" linkConfiguration="{
 *         action: 'list',
 *         controller: 'Ad',
 *         extensionName: 'uiLoremIpsum',
 *         pluginName: 'ads'
 *     }" />
 * </html>
 */
class PaginationViewHelper extends AbstractWidgetViewHelper
{
    /**
     * @var \UI\UiProvider\ViewHelpers\Widget\Controller\PaginationController
     */
    protected $controller;

    /**
     * @param \UI\UiProvider\ViewHelpers\Widget\Controller\PaginationController $controller
     */
    public function injectPaginationController(\UI\UiProvider\ViewHelpers\Widget\Controller\PaginationController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Initialize arguments.
     *
     * @api
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('totalItems', 'integer', 'Total number of items to paginate', true);
        $this->registerArgument('itemsOffset', 'integer', 'Offset of the items on the current page', false, 0);
        $this->registerArgument('itemsPerPage', 'integer', 'Number of items per paginated page', false, 10);
        $this->registerArgument('maxPaginationLinks', 'integer', 'Max. number of links in pagination', false, 10);
        $this->registerArgument('linkConfiguration', 'array', 'Link configuration', false, []);
    }

    /**
     * @return string
     * @throws \UnexpectedValueException
     */
    public function render()
    {
        return $this->initiateSubRequest();
    }
}
