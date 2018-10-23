<?php

namespace Chancenportal\Chancenportal\Utility;

/**
 * Class MailUtility
 * @codeCoverageIgnore
 */
class TranslationUtility extends AbstractUtility
{
    /**
     * @param $key
     * @param null $arguments
     * @return null|string
     */
    static function getTranslation($key, $arguments = null)
    {
        return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, 'chancenportal', $arguments);
    }
}
