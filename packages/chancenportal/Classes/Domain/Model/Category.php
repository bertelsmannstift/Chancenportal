<?php
namespace Chancenportal\Chancenportal\Domain\Model;


/***
 *
 * This file is part of the "Chancenportal" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/
/**
 * Category
 */
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Offer>
     * @cascade remove
     */
    protected $offers = null;

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $images = null;

    /**
     * color
     *
     * @var string
     */
    protected $color = '';

    /**
     * children
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Category>
     * @cascade remove
     */
    protected $children = null;

    /**
     * parent
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\Category
     */
    protected $parent = null;

    /**
     * @return null
     */
    public function getTheme()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
        $setting = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        $themeMapping = $setting['chancenportal']['categoryThemeMapping'];
        return isset($themeMapping[$this->getUid()]) ? $themeMapping[$this->getUid()] : null;
    }

    /**
     * __construct
     */
    public function __construct()
    {

        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->children = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Adds a Category
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Category $child
     * @return void
     */
    public function addChild(\Chancenportal\Chancenportal\Domain\Model\Category $child)
    {
        $this->children->attach($child);
    }

    /**
     * Removes a Category
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Category $childToRemove The Category to be removed
     * @return void
     */
    public function removeChild(\Chancenportal\Chancenportal\Domain\Model\Category $childToRemove)
    {
        $this->children->detach($childToRemove);
    }

    /**
     * Returns the children
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Category> $children
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Sets the children
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Category> $children
     * @return void
     */
    public function setChildren(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $children)
    {
        $this->children = $children;
    }

    /**
     * Returns the parent
     *
     * @return \Chancenportal\Chancenportal\Domain\Model\Category $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets the parent
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Category $parent
     * @return void
     */
    public function setParent(\Chancenportal\Chancenportal\Domain\Model\Category $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->images->attach($image);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove The FileReference to be removed
     * @return void
     */
    public function removeImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove)
    {
        $this->images->detach($imageToRemove);
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images)
    {
        $this->images = $images;
    }

    /**
     * Returns the color
     *
     * @return string $color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Sets the color
     *
     * @param string $color
     * @return void
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
}
