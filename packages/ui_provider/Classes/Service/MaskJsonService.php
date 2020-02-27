<?php
namespace UI\UiProvider\Service;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class MaskJsonService
 * @package UI\UiProvider\Service
 *
 * Handle split mask configuration json files. Based on https://github.com/Gernott/mask/pull/40
 * TODO: Refactor according to https://github.com/Gernott/mask/pull/40
 */
class MaskJsonService
{
    /**
     * @var self|null
     */
    private static $_instance = null;

    /**
     * json configuration
     * @var array
     */
    private $json = null;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @return MaskJsonService
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self;

            /* @var $message \TYPO3\CMS\Core\Messaging\FlashMessage */
            self::$_instance->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        }
        return self::$_instance;
    }

    /**
     * @param string $path
     * @return array
     * @throws \TYPO3\CMS\Core\Exception
     */
    public function getConfiguration($path = '')
    {
        if ($this->json !== null) {
            return $this->json;
        }

        if (substr($path, -strlen('.json')) == '.json') {
            // path points to a file
            $this->json = json_decode(GeneralUtility::getUrl($path), true) ?: [];
            return $this->json;
        }

        // path points to directory
        $this->json = [];
        $configurationFiles = GeneralUtility::getFilesInDir($path, 'json', true);
        foreach ($configurationFiles as $filePath) {
            $content = json_decode(GeneralUtility::getUrl($filePath), true) ?: [];
            $errors = $this->searchForMergeError($this->json, $content);

            if (empty($errors)) {

                if(substr($filePath, -16) === 'mask_export.json') {
                    $content = [
                        'mask_export' => $content
                    ];
                }

                ArrayUtility::mergeRecursiveWithOverrule($this->json, $content);
                continue;
            }

            foreach ($errors as $key => $error) {
                $this->createFlashMessage(
                    sprintf('mask - merge error at file "%s"', basename($filePath)),
                    sprintf(
                        '"%s" differs from current "%s" to new value "%s"',
                        $key,
                        $error['current'],
                        $error['mergeValue']
                    )
                );
            }
        }

        return $this->json;
    }

    /**
     * @param string $path
     * @param array  $data
     */
    public function saveConfiguration($path, $data = [])
    {
        // check if path points to a file
        if (substr($path, -strlen('.json')) == '.json') {
            GeneralUtility::writeFile($path, $this->encodeJSON($data));
        } else {
            // path points to directory
            if (!is_dir($path)) {
                GeneralUtility::mkdir_deep($path);
            }

            $modules = $this->extractModules($data);
            foreach ($modules as $key => $data) {
                $filePath = rtrim($path, '/') . '/' . $key . '.json';
                GeneralUtility::writeFile($filePath, $this->encodeJSON($data));
            }
        }
    }

    /**
     * extracts all modules from configuration
     *
     * @param $data
     *
     * @return array
     */
    public function extractModules($data)
    {
        if (empty($data)) {
            return [];
        }

        $modules = [];
        foreach ($data as $table => $cfg) {
            if ($table === 'mask_export') {
                $modules['mask_export'] = $cfg;
            }
            if (!isset($cfg['elements'])) {
                continue;
            }
            foreach ($cfg['elements'] as $elKey => $elCfg) {
                // initialize create module
                $module = [];
                $module[$table]['elements'][$elKey] = $elCfg;
                $module[$table]['sql'] = array_intersect_key($cfg['sql'], array_flip($elCfg['columns']));
                $module[$table]['tca'] = array_intersect_key($cfg['tca'], array_flip($elCfg['columns']));

                // add additional tables based on column names
                foreach ($elCfg['columns'] as $column) {
                    if (isset($data[$column])) {
                        $module[$column] = $data[$column];
                    }
                }

                // get all database fields from current module tables
                $currentFields = [];
                foreach ($module as $modCfg) {
                    if (isset($modCfg['sql'])) {
                        $currentFields = array_merge($currentFields, array_keys($modCfg['sql']));
                    }
                }

                // find used sys_file_references and add them to module data
                $references = array_filter($data['sys_file_reference']['sql'], function ($key) use ($currentFields) {
                    return in_array($key, $currentFields);
                }, ARRAY_FILTER_USE_KEY);
                if (!empty($references)) {
                    $module['sys_file_reference']['sql'] = $references;
                }

                $modules[$table . '_' . $elKey] = $module;
            }
        }

        return $modules;
    }

    /**
     * Recursively computes the intersection of arrays using keys for comparison.
     *
     * @param   array $array1 The array with master keys to check.
     * @param   array $array2 An array to compare keys against.
     *
     * @return  array associative array containing all the entries of array1 which have keys that are present in array2.
     **/
    private function searchForMergeError(array $array1, array $array2)
    {
        $flatArray1 = ArrayUtility::flatten($array1);
        $flatArray2 = ArrayUtility::flatten($array2);
        $intersection = array_intersect_key($flatArray1, $flatArray2);

        $errors = [];
        foreach ($intersection as $key => $value) {
            if ($value == $flatArray2[$key]) {
                unset($intersection[$key]);
            } else {
                $errors[$key] = [
                    'current'    => $value,
                    'mergeValue' => $flatArray2[$key],
                ];
            }
        }

        return $errors;
    }


    /**
     * Return JSON formatted in PHP 5.4.0 and higher
     *
     * @param $data
     *
     * @return string
     */
    private function encodeJSON($data)
    {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            return json_encode($data);
        }
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * creates flash message into mask message queue
     *
     * @param $title
     * @param $message
     * @param int $severity
     * @throws \TYPO3\CMS\Core\Exception
     */
    private function createFlashMessage($title, $message, $severity = FlashMessage::ERROR)
    {
        /* @var $flashMessage \TYPO3\CMS\Core\Messaging\FlashMessage */
        $flashMessage = GeneralUtility::makeInstance(FlashMessage::class, $message, $title, $severity);

        /* @var $flashMessageService \TYPO3\CMS\Core\Messaging\FlashMessageService */
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $flashMessageService->getMessageQueueByIdentifier('extbase.flashmessages.tx_mask_tools_maskmask')->enqueue($flashMessage);
    }
}