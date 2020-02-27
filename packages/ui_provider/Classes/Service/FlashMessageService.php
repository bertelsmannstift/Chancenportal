<?php
namespace UI\UiProvider\Service;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FlashMessageService
 * @package UI\UiProvider\Service
 */
class FlashMessageService
{
    /**
     * Holds the flash message service instance
     *
     * @var \UI\UiProvider\Service\FlashMessageService
     */
    protected $flashMessageService;

    /**
     * FlashMessageService constructor
     */
    public function __construct()
    {
        $this->flashMessageService = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
    }

    /**
     * @param $headline
     * @param $text
     * @param $severity
     */
    public function displayMessage($headline, $text, $severity = FlashMessage::INFO) {
        $message = GeneralUtility::makeInstance(FlashMessage::class, $text, $headline, $severity);

        $this->flashMessageService
            ->getMessageQueueByIdentifier()
            ->addMessage($message);
    }
}
