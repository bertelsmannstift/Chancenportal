<?php
namespace UI\UiProvider\Persistence\Storage;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class CustomDataMapper extends \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper {
    /**
     * Maps a single row on an object of the given class
     *
     * @param string $className
     * @param array $row
     * @return object
     * @throws \TYPO3\CMS\Extbase\Object\Exception\CannotReconstituteObjectException
     */
    protected function mapSingleRow($className, array $row)
       {
           $row['uid'] = isset($row['_LOCALIZED_UID']) ? $row['_LOCALIZED_UID'] : $row['uid'];

           if ($this->persistenceSession->hasIdentifier($row['uid'], $className)) {
               $object = $this->persistenceSession->getObjectByIdentifier($row['uid'], $className);
           } else {
               $object = $this->createEmptyObject($className);
               $this->persistenceSession->registerObject($object, $row['uid']);
               $this->thawProperties($object, $row);
               $this->emitAfterMappingSingleRow($object);
               $object->_memorizeCleanState();
               $this->persistenceSession->registerReconstitutedEntity($object);
           }
         return $object;
      }
}