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
            if (!$offer->isActive()) {
                continue;
            }

            if ($offer->getDateType() === 0) {
                $offer->setNextCalculatedDate(new \DateTime('today 23:59'));
            } elseif ($offer->getDateType() > 0 && $offer->getDateType() < 4) {
                $ended = true;
                foreach ($offer->getDates() as $date) {
                    if ($date->getEndDate() && $date->getEndDate() !== '0000-00-00') {
                        if ($date->getEndDate()->format('Y-m-d') >= $now->format('Y-m-d')) {
                            $ended = false;
                        }
                    } else if ($date->getStartDate() && $date->getStartDate() !== '0000-00-00') {
                        if ($date->getStartDate()->format('Y-m-d') >= $now->format('Y-m-d')) {
                            $ended = false;
                        }
                    }

                    if (!$ended) {
                        break;
                    }
                }

                if (!$ended) {
                    $offer->setNextCalculatedDate($offer->getNextDate());
                } else {
                    $offer->setNextCalculatedDate(null);
                }
            } elseif ($offer->getDateType() === 4) {
                $ended = true;
                if (!$offer->getEndDate() || $offer->getEndDate()->format('Y-m-d') >= $now->format('Y-m-d')) {
                    $ended = false;
                }
                if (!$ended) {
                    $offer->setNextCalculatedDate(new \DateTime('today 23:59'));
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
