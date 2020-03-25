<?php
namespace Chancenportal\Chancenportal\Domain\Repository;


/***
 *
 * This file is part of the "Chancenportal" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/
/**
 * The repository for Logs
 */
class LogRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    ];

    /**
     * Returns all objects of this repository.
     *
     * @return QueryResultInterface|array
     */
    public function findAll($limit = 0)
    {
        $query = $this->createQuery();

        if(intval($limit) > 0) {
            $query->setLimit(intval($limit));
        }

        return $query->execute();
    }
}
