<?php

namespace Chancenportal\Chancenportal\Utility;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;


/**
 * Class MailUtility
 * @codeCoverageIgnore
 */
class MailUtility extends AbstractUtility
{
    static function sendTemplateEmail(
        array $recipient,
        array $sender,
        array $replyTo = array(),
        $subject = '',
        $templateName = '',
        array $variables = array(),
        array $attachments = array()
    ) {
        if(empty(reset($recipient)) || empty(reset($sender))) {
            return false;
        }

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $emailView = $objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $emailView->setFormat('html');
        $emailView->getRequest()->setControllerExtensionName('Chancenportal');

        $templatePathAndFilename = self::getTemplateFile($templateName);

        $emailView->setTemplatePathAndFilename($templatePathAndFilename);
        $emailView->assignMultiple($variables);
        $emailBody = $emailView->render();

        $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');

        $message->setTo($recipient)
            ->setFrom($sender)
            ->setSubject($subject)
            ->setReplyTo($replyTo);

        if (count($attachments)) {
            foreach ($attachments as $fileName => $attachment) {
                if ($attachment) {
                    $message->attach(\Swift_Attachment::fromPath($attachment)->setFilename($fileName));
                }
            }
        }

        $msgId = $message->getHeaders()->get('Message-ID');
        $msgId->setId(microtime(true) . '.' . uniqid($templateName . 'chancenportal') . '@' . $_SERVER["SERVER_NAME"]);

        // HTML Email
        $message->setBody($emailBody, 'text/html');
        $message->send();

        return $message->isSent();
    }

    /**
     * @param $filename
     * @return string
     * @throws \Exception
     */
    static function getTemplateFile($filename)
    {
        $file = ExtensionManagementUtility::extPath('chancenportal') . 'Resources/Private/Templates/Email/' . $filename;
        if (!is_file($file)) {
            throw new \Exception('Template file not found:' . $file);
        }
        return $file;
    }
}
