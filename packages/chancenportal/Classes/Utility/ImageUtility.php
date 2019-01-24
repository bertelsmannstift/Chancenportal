<?php

namespace Chancenportal\Chancenportal\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ImageUtility
 * @package Chancenportal\Chancenportal\Utility
 */
class ImageUtility
{
    /**
     * @param $newStorageUid
     * @param $file
     * @param $field
     * @param $table
     * @param $storagePid
     */
    public static function buildRelations($newStorageUid, $file, $field, $table, $storagePid)
    {

        $data = array();
        $data['sys_file_reference']['NEW_IMAGE_CHANCENPORTAL'] = array(
            'uid_local' => $file->getUid(),
            'uid_foreign' => $newStorageUid, // uid of your content record or own model
            'tablenames' => $table, //tca table name
            'fieldname' => $field, //see tca for fieldname
            'pid' => $storagePid,
            'table_local' => 'sys_file',
        );
        $data[$table][$newStorageUid] = array('image' => 'NEW_IMAGE_CHANCENPORTAL');

        /** @var \TYPO3\CMS\Core\DataHandling\DataHandler $tce */
        $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\DataHandling\DataHandler'); // create TCE instance
        // $tce->bypassAccessCheckForRecords = true;
        $tce->start($data, array());
        // $tce->admin = true;
        $tce->process_datamap();
    }

    /**
     * @param Object $obj Model object
     * @param String $contentImageString Data inline image base64
     * @param String $imageFilename Save to filename
     * @param String $folderPath Save path
     * @return null|object
     */
    public static function handleBase64Image($obj, $contentImageString, $imageFilename, $folderPath)
    {
        try {
            if (preg_match('/^data:image\/(\w+);base64,/', $contentImageString, $type)) {
                $contentImageString = substr($contentImageString, strpos($contentImageString, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif

                if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                    return null;
                }

                $contentImageString = base64_decode($contentImageString);

                if ($contentImageString === false) {
                    return null;
                }

                $file = GeneralUtility::tempnam('image_');
                GeneralUtility::writeFile($file, $contentImageString);

                /** @var $storageRepository \TYPO3\CMS\Core\Resource\StorageRepository */
                $storageRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
                $storage = $storageRepository->findByUid('1');

                if (!$storage->hasFolder($folderPath . $obj->getUid())) {
                    $targetFolder = $storage->createFolder($folderPath . $obj->getUid());
                } else {
                    $targetFolder = $storage->getFolder($folderPath . $obj->getUid());
                }

                $originalFilePath = $file;
                $newFileName = explode('.', $imageFilename);
                array_pop($newFileName);
                $newFileName = implode('.', $newFileName) . '.' . ($type === 'png' ? 'png' : 'jpg');

                if (file_exists($originalFilePath)) {
                    $fileObject = $storage->addFile($originalFilePath, $targetFolder, $newFileName);
                    $objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);

                    $fileResourceReference = new \TYPO3\CMS\Core\Resource\FileReference(array('uid_local' => $fileObject->getUid()));

                    $fileReference = $objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Model\\FileReference');
                    $fileReference->setOriginalResource($fileResourceReference);
                    return $fileReference;
                }
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        return null;
    }

    public static function isPng($data) {
        $png_binary_check = "\x89\x50\x4e\x47\x0d\x0a\x1a\x0a";
        if (substr($data, 0, strlen($png_binary_check)) === $png_binary_check) {
            return true;
        }
        return false;
    }
}
