<?php
namespace UI\UiProvider\Persistence\Storage;

class CustomQueryResult extends \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult {

    /**
     * @var \UI\UiProvider\Persistence\Storage\CustomDataMapper
     * @inject
     */
    protected $dataMapper;
}