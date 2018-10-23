<?php
namespace UI\UiForms\Xclass\Finishers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ConfirmationFinisher extends \TYPO3\CMS\Form\Domain\Finishers\ConfirmationFinisher
{
    protected $objectManager;
    protected $configurationManager;

    /**
     * Executes this finisher
     * @see AbstractFinisher::execute()
     *
     * @throws FinisherException
     */
    protected function executeInternal()
    {
        $formRuntime = $this->finisherContext->getFormRuntime();
        $message = $this->parseOption('message');

        /**
         * Create Standalone View
         */
        $this->objectManager            = GeneralUtility::makeInstance(ObjectManager::class);
        $this->configurationManager     = $this->objectManager->get(ConfigurationManagerInterface::class);
        $standaloneView                 = $this->objectManager->get(StandaloneView::class);
        $extbaseFrameworkConfiguration  = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        $standaloneView->setLayoutRootPaths($extbaseFrameworkConfiguration['view']['layoutRootPaths']);
        $standaloneView->setPartialRootPaths($extbaseFrameworkConfiguration['view']['partialRootPaths']);
        $standaloneView->setTemplateRootPaths($extbaseFrameworkConfiguration['view']['templateRootPaths']);

        $standaloneView->setTemplate('Finisher/Confirmation');

        $standaloneView->assignMultiple([
            'message' => $message
        ]);

        $message = trim($standaloneView->render());

        $formRuntime->getResponse()->setContent($message);
    }
}
