<?php
namespace UI\UiCeOverrides\ViewHelpers\Teaserblock;

/***
 *
 * This file is part of the "u+i Content Elements (Overrides)" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 www.uandi.com
 *
 ***/

use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use TYPO3\CMS\Fluid\ViewHelpers\Uri\TypolinkViewHelper;
use TYPO3\CMS\Fluid\ViewHelpers\Uri\ImageViewHelper;


class EncodeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @var \TYPO3\CMS\Extbase\Service\ImageService
     * @inject
     */
    protected $imageService;

    /**
     * @param string $items Teaserblock item
     * @return string json format
     */

    public function render($items = null) {

        $data = array();

        foreach ($items as $item) {

            $context = $this->objectManager->get(RenderingContext::class);
            $image = ImageViewHelper::renderStatic(['image' => $item['data_tx_uice_teaserblock_item_image'][0], 'maxWidth' => 800, 'maxHeight' => 800], function(){}, $context);
            $link = TypolinkViewHelper::renderStatic(['parameter' => $item['data']['tx_uice_teaserblock_item_link']],  function(){} , $context);

            $data[] = array(
                'width' => $item['data']['tx_uice_teaserblock_item_layout'],
                'href' => $link,
                'heading' => $item['data']['tx_uice_teaserblock_item_headline'],
                'text' => $item['data']['tx_uice_teaserblock_item_text'],
                'image' => $image,
                'flag' => array(
                    'label' => $item['data']['tx_uice_teaserblock_item_topic'],
                    'type' => $item['data']['tx_uice_teaserblock_item_topic_theme']
                )
            );
        }

        return '{"list": ' . json_encode($data) . '}';
    }
}
