<?php
namespace Chancenportal\Chancenportal\DataProcessing;

use Chancenportal\Chancenportal\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class ThemeColorsProcessor
 * @package Chancenportal\Chancenportal\DataProcessing
 */
class ThemeColorsProcessor implements DataProcessorInterface
{
    /**
     * Process data of a record to resolve a news record
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }

        if($cObj->getCurrentTable() !== 'pages') {
            return $processedData;
        }

        /** Get the category repository */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $categoryRepository = $objectManager->get(CategoryRepository::class);

        $query = $categoryRepository->createQuery();
        $query->matching($query->logicalAnd($query->equals('parent', '')));
        $categories = $query->execute();

        $categoryColors = [];
        foreach ($categories as $category) {
            if (!empty($category->getColor())) {
                $categoryColors[$category->getUid()] = [
                    'uid' => $category->getUid(),
                    'color' => $category->getColor(),
                    'color2' => $this->colorLuminance($category->getColor(), -0.4),
                    'color3' => $this->colorLuminance($category->getColor(), 0.2),
                ];
            }
        }

        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration, 'news');
        $processedData[$targetVariableName] = $categoryColors;

        return $processedData;
    }

    /**
     * @param $hex
     * @param $percent
     * @return string
     */
    private function colorLuminance($hex, $percent)
    {
        $hex = preg_replace('/[^0-9a-f]/i', '', $hex);
        $new_hex = '#';
        if (strlen($hex) < 6) {
            $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
        }
        for ($i = 0; $i < 3; $i++) {
            $dec = hexdec(substr($hex, $i * 2, 2));
            $dec = min(max(0, $dec + $dec * $percent), 255);
            $new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
        }

        return $new_hex;
    }
}
