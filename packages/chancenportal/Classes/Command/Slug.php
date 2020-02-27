<?php
namespace Chancenportal\Chancenportal\Command;

use Chancenportal\Chancenportal\Domain\Model\Offer;
use Chancenportal\Chancenportal\Domain\Model\Provider;
use Chancenportal\Chancenportal\Domain\Repository\OfferRepository;
use Chancenportal\Chancenportal\Domain\Repository\ProviderRepository;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\RepositoryInterface;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Class Slug
 * @package Uiartikel\UiArtikel\Command
 */
class Slug extends AbstractTask
{
    /**
     * @var ObjectManager
     */
    protected $objectManager = NULL;

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager = NULL;

    /**
     * @return bool
     */
    public function execute()
    {
        ignore_user_abort(true);
        set_time_limit('0');
        ini_set('max_execution_time', 0);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $this->updateSlugs(OfferRepository::class, 'tx_chancenportal_domain_model_offer');
        $this->updateSlugs(ProviderRepository::class, 'tx_chancenportal_domain_model_provider');
        return true;
    }

    /**
     * @param $className
     * @param $table
     */
    function updateSlugs($className, $table)
    {
        /** @var RepositoryInterface $repository */
        $repository = $this->objectManager->get($className);
        $query = $repository->createQuery();

        $query->getQuerySettings()
            ->setRespectSysLanguage(false)
            ->setIgnoreEnableFields(true);

        /** @var Offer|Provider $entry */
        foreach ($query->execute() as $entry) {
            $entry->setSlug($this->generateSlug($entry->getName() . ' ' . $entry->getUid(), $table));
            $repository->update($entry);
        }
        $this->persistenceManager->persistAll();
    }

    /**
     * @param $title
     * @param $table
     * @return string
     */
    function generateSlug($title, $table)
    {
        $title = preg_replace('/\//is', '-', $title);
        $fieldName = 'slug';
        $fieldConfig = $GLOBALS['TCA'][$table]['columns'][$fieldName]['config'];
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, $table, $fieldName, $fieldConfig);
        return $slugHelper->sanitize('/' . $title);
    }
}
