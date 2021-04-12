<?php

namespace Chancenportal\Chancenportal\Command;

use Chancenportal\Chancenportal\Domain\Repository\OfferRepository;
use Chancenportal\Chancenportal\Utility\OfferUtility;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Class MigrationsCommand
 */
class UpdateNextDateCommand extends Command
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\OfferRepository
     */
    protected $offerRepository = null;

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->offerRepository = $objectManager->get(OfferRepository::class);
        $this->persistenceManager = $objectManager->get(PersistenceManager::class);

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Updates the NextDate field on all offers');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        OfferUtility::updateNextDate();

        return 0;
    }
}
