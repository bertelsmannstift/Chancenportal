<?php

namespace Chancenportal\Chancenportal\Utility;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * @package DpnGlossary
 * @subpackage Service
 */
class LinkService implements SingletonInterface
{
    /**
     * @var \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder
     */
    protected $uriBuilder;

    public function __construct()
    {
        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManager::class);
        /** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObjectRenderer */
        $contentObjectRenderer = $objectManager->get(ContentObjectRenderer::class);
        $configurationManager->setContentObject($contentObjectRenderer);
        $this->uriBuilder = $objectManager->get(UriBuilder::class);
        $this->uriBuilder->injectConfigurationManager($configurationManager);
    }

    /**
     * @param int $pageId
     * @param array $arguments
     * @param bool $absolut
     * @param int $sysLanguageUid
     * @return string
     */
    public function buildLink($pageId, array $arguments = array(), $absolut = true, $sysLanguageUid = 0)
    {
        if (0 < $sysLanguageUid) {
            $arguments = array_merge(
                array('L' => $sysLanguageUid),
                $arguments
            );
        }
        return $this->uriBuilder
            ->reset()
            ->setTargetPageUid($pageId)
            ->setArguments($arguments)
            ->setCreateAbsoluteUri($absolut)
            ->buildFrontendUri();
    }
}
