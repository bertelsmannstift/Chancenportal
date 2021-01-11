<?php
namespace Chancenportal\Chancenportal\Domain;

class Registry extends \TYPO3\CMS\Core\Registry
{
    /**
     * @return array
     */
    public function getByNamespace($namespace)
    {
        $this->loadEntriesByNamespace($namespace);
        return $this->entries[$namespace];
    }
}
