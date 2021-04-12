<?php

namespace Chancenportal\Chancenportal\Utility;

use Chancenportal\Chancenportal\Domain\Repository\OfferRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Class OfferUtility
 * @package Chancenportal\Chancenportal\Utility
 */
class OfferUtility extends AbstractUtility
{
    public static function updateNextDate() {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $offerRepository = $objectManager->get(OfferRepository::class);
        $persistenceManager = $objectManager->get(PersistenceManager::class);
        $registry = GeneralUtility::makeInstance(\Chancenportal\Chancenportal\Domain\Registry::class);

        $offers = $offerRepository->findAll();
        $now = new \DateTime('midnight');

        /** @var Offer $offer */
        foreach ($offers as $offer) {
            if ($offer->getDateType() === 0) {
                $offer->setNextCalculatedDate($offer->getNextDate());
            } elseif ($offer->getDateType() > 0) {
                $ended = true;
                foreach ($offer->getDates() as $date) {
                    if ($date->getEndDate() && ($date->getEndDate()->format('Y-m-d') >= $now->format('Y-m-d') || $date->getEndDate() === null || $date->getEndDate() === '0000-00-00')) {
                        $ended = false;
                    }
                }

                if (!$ended) {
                    $offer->setNextCalculatedDate($offer->getNextDate());
                } else {
                    $offer->setNextCalculatedDate(null);
                }
            } else {
                $offer->setNextCalculatedDate(null);
            }


            $offerRepository->update($offer);
        }

        $registry->set('chancenportal', 'updateNextOfferDate_LastRun', time());

        $persistenceManager->persistAll();
    }
}
