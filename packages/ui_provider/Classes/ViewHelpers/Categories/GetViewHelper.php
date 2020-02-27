<?php

namespace UI\UiProvider\ViewHelpers\Categories;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Tjark Süßen <tsuessen@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Class GetViewHelper
 * @package UI\UiProvider\ViewHelpers\Categories
 * 
 * Returns categories array
 *
 * Usage
 * -----
 * {uandi:categories(currentPageUid: '1', parentCategoryUid: '1') -> v:variable.set(name: 'categories')}
 *
 * @TODO: Is this still needed? If so, refactor some things like $GLOBALS['TSFE']->sys_language_uid
 *
 */
class GetViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
     *
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    public $categoryRepository;

    /**
     * Initialize arguments.
     */
    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerArgument('currentPageUid', 'string', 'Current page uid');
        $this->registerArgument('parentCategoryUid', 'string', 'Parent category uid');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return array|mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $objectManager = $renderingContext->getObjectManager();
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category_record_mm');

        $query = $queryBuilder
            ->select('sys_category_record_mm.uid_local')
            ->from('sys_category_record_mm')
            ->join(
                'sys_category_record_mm',
                'sys_category',
                'overlay',
                'sys_category_record_mm.uid_local = overlay.uid'
            )
            ->where('overlay.sys_language_uid = :currentLanguage')
            ->groupBy('sys_category_record_mm.uid_local')
            ->setParameter('currentPageUid', $arguments['currentPageUid'])
            ->setParameter('parentCategoryUid', $arguments['parentCategoryUid'])
            ->setParameter('currentLanguage', $GLOBALS['TSFE']->sys_language_uid);        

            if ($arguments['currentPageUid'] !== null) {
                $query->andwhere('sys_category_record_mm.uid_foreign = :currentPageUid');
            }

            if ($arguments['parentCategoryUid'] !== null) {
                $query->andwhere('overlay.parent = :parentCategoryUid');
            }

        $result = $query->execute();
        $categoryUids = $result->fetchAll();
        $categories = [];
        foreach ($categoryUids as $categoryUid) {
            $categoryRepository = $objectManager->get(CategoryRepository::class);
            $category = $categoryRepository->findByUid($categoryUid['uid_local']);
        
            $categoriesItem = [
                'id' => $category->getUid(),
                'title' => $category->getTitle(),
            ];
            array_push($categories, $categoriesItem);
        }
        return $categories;      
    }
}