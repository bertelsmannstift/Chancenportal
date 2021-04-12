<?php

namespace UI\UiSitepackage\Utility;

class GeneralUtility extends \TYPO3\CMS\Core\Utility\GeneralUtility
{
    /**
     * @param string $string
     * @return string|string[]|null
     */
    public static function compressHtmlSource($string)
    {
        $sr = [
            '/\/\*\*.\*\//' => ' ', // remove javascript inline comments
            '/\n/' => ' ', // convert linebreaks to spaces
            '/\t/' => ' ', // convert tabs to spaces
            '/[ ]+/' => ' ', // convert multible spaces to one single space
            '/\>\s\<(?:(?!(?:a|b|strong|img|em|i|span|small|big)[ ]))/' => '><', // remove spaces between tags, but ignore on some inline-tags
        ];

        // replace content with a compressed string
        return preg_replace(array_keys($sr), array_values($sr), $string);
    }
}
