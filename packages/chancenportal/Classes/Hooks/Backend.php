<?php

namespace Chancenportal\Chancenportal\Hooks;

use Chancenportal\Chancenportal\Utility\MailUtility;

class Backend
{
    public function processDatamap_afterDatabaseOperations($status, $table, $id, $fieldArray, $pObj)
    {
        // Check if any fields are actually updated:
        if (count($fieldArray) && $table === 'fe_users') {

            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
            $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
            $userRepository = $objectManager->get('Chancenportal\\Chancenportal\\Domain\\Repository\\FrontendUserRepository');
            $user = $userRepository->findByUid($id);

            if($fieldArray['disable'] === '0' && $user && $user->getConfirmationSend() === false) {
                if($user) {
                    $user->setConfirmationSend(true);
                    $persistenceManager->update($user);
                    $persistenceManager->persistAll();
                    $setting = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
                    $host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                    MailUtility::sendTemplateEmail([$user->getUsername()], [$setting['chancenportal']['email']['sender']], [], $setting['chancenportal']['email']['confirm_subject'], 'Confirm.html', [
                        'settings' => $setting,
                        'host' => $host,
                        'user' => $user,
                    ]);
                }

                $this->addMessage('Bestätigungsmail wurde gesendet!');
            }
        }
    }

    public function addMessage($msg, $type = \TYPO3\CMS\Core\Messaging\FlashMessage::INFO)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            '',
            $msg,
            $type,
            true
        );
        $flashMessageService = $objectManager->get(
            \TYPO3\CMS\Core\Messaging\FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);
    }
}
