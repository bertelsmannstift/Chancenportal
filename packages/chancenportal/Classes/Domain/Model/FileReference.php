<?php

namespace Chancenportal\Chancenportal\Domain\Model;

class FileReference extends \TYPO3\CMS\Extbase\Domain\Model\FileReference
{

    /**
     * @params \TYPO3\CMS\Core\Resource\File $file
     */
    public function setFile(\TYPO3\CMS\Core\Resource\File $file)
    {
        $this->originalFileIdentifier = (int)$file->getUid();
    }
}
