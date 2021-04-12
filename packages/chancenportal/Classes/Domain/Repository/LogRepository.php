<?php
namespace Chancenportal\Chancenportal\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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

    /**
     * @param array $constraints
     * @return array
     */
    public function getOfferLogs($constraints = []) {
        $offers = [];

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_chancenportal_domain_model_log');
        $queryBuilder
            ->selectLiteral(
                'offer.uid',
                'offer.name',
                'COUNT(offer.uid) AS count'
            )
            ->from('tx_chancenportal_domain_model_log', 'log')
            ->leftJoin(
                'log',
                'tx_chancenportal_domain_model_offer',
                'offer',
                $queryBuilder->expr()->eq('offer.uid', $queryBuilder->quoteIdentifier('log.offer'))
            )
            ->groupBy('offer.uid')
            ->orderBy('count', 'DESC');

        if (!empty($constraints)) {
            if (!empty($constraints['date_start'])) {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->gte('log.date', $queryBuilder->createNamedParameter($constraints['date_start'], \PDO::PARAM_STR))
                );
            }

            if (!empty($constraints['date_end'])) {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->lte('log.date', $queryBuilder->createNamedParameter($constraints['date_end'], \PDO::PARAM_STR))
                );
            }
        }

        $statement = $queryBuilder->execute();
        if ($statement instanceof \Doctrine\DBAL\Driver\Statement) {
            $_offers = $statement->fetchAll();

            foreach ($_offers as $offer) {
                $offers[$offer['uid']] = [
                    'name' => $offer['name'],
                    'count' =>  $offer['count']
                ];
            }
        }

        return $offers;
    }

    /**
     * @param array $constraints
     * @return array
     */
    public function getCategoryLogs($constraints = []) {
        $categories = [];

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_chancenportal_domain_model_log');
        $queryBuilder
            ->selectLiteral(
                'category.uid',
                'category.name',
                'COUNT(category.uid) AS count'
            )
            ->from('tx_chancenportal_domain_model_log', 'log')
            ->leftJoin(
                'log',
                'tx_chancenportal_domain_model_category',
                'category',
                $queryBuilder->expr()->eq('category.uid', $queryBuilder->quoteIdentifier('log.category'))
            )
            ->groupBy('category.uid')
            ->orderBy('count', 'DESC');

        if (!empty($constraints)) {
            if (!empty($constraints['date_start'])) {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->gte('log.date', $queryBuilder->createNamedParameter($constraints['date_start'], \PDO::PARAM_STR))
                );
            }

            if (!empty($constraints['date_end'])) {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->lte('log.date', $queryBuilder->createNamedParameter($constraints['date_end'], \PDO::PARAM_STR))
                );
            }
        }

        $statement = $queryBuilder->execute();
        if ($statement instanceof \Doctrine\DBAL\Driver\Statement) {
            $_categories = $statement->fetchAll();

            foreach ($_categories as $category) {
                $categories[$category['uid']] = [
                    'name' => $category['name'],
                    'count' =>  $category['count']
                ];
            }
        }

        return $categories;
    }

    /**
     * @param array $constraints
     * @return array
     */
    public function getTermLogs($constraints = []) {
        $terms = [];

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_chancenportal_domain_model_log');
        $queryBuilder
            ->selectLiteral(
                'term',
                'COUNT(term) AS count'
            )
            ->from('tx_chancenportal_domain_model_log', 'log')
            ->where(
                $queryBuilder->expr()->neq(
                    'term',
                    $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)
                )
            )
            ->groupBy('term')
            ->orderBy('count', 'DESC');

        if (!empty($constraints)) {
            if (!empty($constraints['date_start'])) {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->gte('log.date', $queryBuilder->createNamedParameter($constraints['date_start'], \PDO::PARAM_STR))
                );
            }

            if (!empty($constraints['date_end'])) {
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->lte('log.date', $queryBuilder->createNamedParameter($constraints['date_end'], \PDO::PARAM_STR))
                );
            }
        }

        $statement = $queryBuilder->execute();
        if ($statement instanceof \Doctrine\DBAL\Driver\Statement) {
            $_terms = $statement->fetchAll();

            foreach ($_terms as $term) {
                $terms[$term['term']] = [
                    'name' => $term['term'],
                    'count' =>  $term['count']
                ];
            }
        }

        return $terms;
    }
}
