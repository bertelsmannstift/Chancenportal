<?php

namespace Chancenportal\Chancenportal\Command;

use Chancenportal\Chancenportal\Domain\Model\Provider;
use Chancenportal\Chancenportal\Domain\Repository\OfferRepository;
use Chancenportal\Chancenportal\Domain\Repository\ProviderRepository;
use Chancenportal\Chancenportal\Utility\FrontendUriBuilderUtility;
use Chancenportal\Chancenportal\Utility\LinkService;
use Chancenportal\Chancenportal\Utility\MailUtility;
use Chancenportal\Chancenportal\Utility\UserUtility;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;
use UI\UiProvider\Utility\GeneralUtility;

/**
 * Class Checker
 * @package Chancenportal\Chancenportal\Command
 */
class Checker extends \TYPO3\CMS\Scheduler\Task\AbstractTask
{
    protected $objectManager = null;

    protected $persistenceManager = null;
    protected $configurationManager = null;
    protected $settings = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\OfferRepository
     */
    protected $offerRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\ProviderRepository
     */
    protected $providerRepository = null;

    /**
     * @var LinkService
     */
    private $uriBuilder = null;

    /**
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function execute()
    {
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $this->offerRepository = $this->objectManager->get(OfferRepository::class);
        $this->providerRepository = $this->objectManager->get(ProviderRepository::class);

        $this->uriBuilder = new LinkService;

        $backendConfigurationManager = $this->objectManager->get(BackendConfigurationManager::class);
        $backendConfiguration = $backendConfigurationManager->getConfiguration();
        $this->settings = $backendConfiguration['settings'];

        $this->sendOutdatedEmails();
        $this->sendOldOffersWithoutDatesEmail();

        return true;
    }

    /**
     * Erinnerungsmail an die Anbieter die keine Aktuallisierung mehr am Anbieterprofile oder an den Angeboten vorgenommen haben.
     * Rhythmus: 6 Monate.
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    function sendOutdatedEmails()
    {
        $host = $this->uriBuilder->buildLink(1);
        $sixMonth = (new \DateTime())->modify('-6 month');

        $providerRefreshed = [];
        $providerMailsToSend = [];
        $offers = $this->offerRepository->findAll();
        $providers = $this->providerRepository->findAll();

        foreach ($offers as $offer) {
            if ($offer->getTstamp() < $sixMonth) {
                if ($offer->getProvider()->isReminderEmailSend() === false) {
                    if (!isset($providerMailsToSend[$offer->getProvider()->getUid()])) {
                        $providerMailsToSend[$offer->getProvider()->getUid()] = $this->getProviderUsers($offer->getProvider());
                    }
                }
            } else {
                $providerRefreshed[$offer->getProvider()->getUid()] = true;
            }
        }

        foreach ($providers as $provider) {
            if ($provider->getTstamp() < $sixMonth) {
                if ($provider->isReminderEmailSend() === false) {
                    if (!isset($providerMailsToSend[$provider->getUid()])) {
                        $providerMailsToSend[$provider->getUid()] = $this->getProviderUsers($provider);
                    }
                }
            } else {
                $providerRefreshed[$provider->getUid()] = true;
            }
        }

        foreach ($providerMailsToSend as $providerUid => $users) {
            $provider = $this->providerRepository->findByUid($providerUid);
            if (!isset($providerRefreshed[$providerUid])) {
                $provider->setReminderEmailSend(true);
                $this->providerRepository->update($provider);
                $this->persistenceManager->persistAll();

                foreach ($users as $user) {
                    MailUtility::sendTemplateEmail([$user->getUsername()],
                        [$this->settings['chancenportal']['email']['sender']], [],
                        $this->settings['chancenportal']['email']['outdated_subject'], 'Outdated.html',
                        ['host' => $host, 'user' => $user, 'settings' => $this->settings]);
                }
            }
        }
    }

    /**
     * Erinnerungsmail zu Angeboten ohne Termin (Dauerangebote) an die Anbieter.
     * Rhythmus: 6 Monate.
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    function sendOldOffersWithoutDatesEmail()
    {
        $host = $this->uriBuilder->buildLink(1);
        $offers = $this->getOldOffersWithoutDates();
        $providers = [];
        foreach ($offers as $offer) {
            if (!isset($providers[$offer->getProvider()->getUid()])) {
                $providers[$offer->getProvider()->getUid()] = [
                    'users' => $this->getProviderUsers($offer->getProvider()),
                    'offers' => []
                ];
            }

            $providers[$offer->getProvider()->getUid()]['offers'][] = $offer;
        }

        foreach ($providers as $provider) {
            foreach ($provider['offers'] as $offer) {

                $offer->setReminderEmailSend(true);
                $this->offerRepository->update($offer);
                $this->persistenceManager->persistAll();

                foreach ($provider['users'] as $user) {
                    $offerUrl = $this->uriBuilder->buildLink(
                        $this->settings['chancenportal']['pageIds']['offer_detail'],
                        [
                            'tx_chancenportal_chancenportal[action]' => 'offerDetail',
                            'tx_chancenportal_chancenportal[controller]' => 'Frontend',
                            'tx_chancenportal_chancenportal[offer]' => $offer->getUid(),
                        ]
                    );

                    MailUtility::sendTemplateEmail([$user->getUsername()],
                        [$this->settings['chancenportal']['email']['sender']], [],
                        $this->settings['chancenportal']['email']['old_offers_subject'], 'OldOffers.html',
                        [
                            'settings' => $this->settings,
                            'host' => $host,
                            'user' => $user,
                            'offer' => $offer,
                            'offerUrl' => $offerUrl
                        ]);
                }
            }
        }
    }

    /**
     * @param Provider $provider
     * @return array
     */
    function getProviderUsers(Provider $provider)
    {
        $userItems = [];
        $users = UserUtility::getUsersByProvider($provider);
        foreach ($users as $user) {
            if (UserUtility::isProvider($user)) {
                $userItems[] = $user;
            }
        }
        return $userItems;
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    function getOldOffersWithoutDates()
    {
        $query = $this->offerRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints = [];

        $sixMonth = (new \DateTime())->modify('-6 month');
        $constraints[] = $query->lessThanOrEqual('activeDate', $sixMonth->format('Y-m-d H:i:s'));
        $constraints[] = $query->equals('dateType', 0);
        $constraints[] = $query->equals('active', 1);
        $constraints[] = $query->equals('approved', 1);
        $constraints[] = $query->equals('reminderEmailSend', 0);

        $query->matching($query->logicalAnd($constraints));

        return $query->execute();
    }
}
