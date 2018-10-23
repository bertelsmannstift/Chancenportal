<?php
namespace UI\UiProvider\ViewHelpers\Link;

/***
 *
 * This file is part of the "u+i Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

/**
 * Extension of the standard fluid typolink viewhelper to work with record links
 * The regular viewhelper doesn't output class or target definitions for record links.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Service\TypoLinkCodecService;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

class TypolinkViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Link\TypolinkViewHelper
{
    /**
     * Render
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed|string
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $parameter = $arguments['parameter'];
        $target = $arguments['target'];
        $class = $arguments['class'];
        $title = $arguments['title'];
        $additionalParams = $arguments['additionalParams'];
        $additionalAttributes = $arguments['additionalAttributes'];
        $useCacheHash = $arguments['useCacheHash'];

        // Merge the $parameter with other arguments
        $typolinkParameter = self::createTypolinkParameterArrayFromArguments($parameter, $target, $class, $title, $additionalParams);

        // array(param1 -> value1, param2 -> value2) --> param1="value1" param2="value2" for typolink.ATagParams
        $extraAttributes = [];
        foreach ($additionalAttributes as $attributeName => $attributeValue) {
            $extraAttributes[] = $attributeName . '="' . htmlspecialchars($attributeValue) . '"';
        }
        $aTagParams = implode(' ', $extraAttributes);

        // If no link has to be rendered, the inner content will be returned as such
        $content = (string)$renderChildrenClosure();

        /**
         * Custom Link Rendering starts here
         */
        $contentOut = '<a';

        $typoLinkCodec = GeneralUtility::makeInstance(TypoLinkCodecService::class);
        $typolinkConfiguration = $typoLinkCodec->decode($typolinkParameter);
        if(!empty($typolinkConfiguration)) {
            if(!empty($typolinkConfiguration['url'])) {
                $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
                $url = $contentObject->typoLink_URL(
                    [
                        'parameter' => $typolinkConfiguration['url'],
                        'useCacheHash' => $useCacheHash,
                    ]
                );

                if($url) {
                    $contentOut .= ' href="'.$url.'"';
                }
            }

            if(!empty($typolinkConfiguration['class'])) {
                $contentOut .= ' class="'.$typolinkConfiguration['class'].'"';
            }

            if(!empty($typolinkConfiguration['target'])) {
                $contentOut .= ' target="'.$typolinkConfiguration['target'].'"';
            }

            if(!empty($aTagParams)) {
                $contentOut .= ' ' . $aTagParams;
            }
        }

        $contentOut .= '>' . $content . '</a>';

        return $contentOut;
    }
}
