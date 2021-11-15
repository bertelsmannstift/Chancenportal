<?php
namespace Chancenportal\Chancenportal\Domain\Model;

use Chancenportal\Chancenportal\Utility\UserUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * FrontendUser
 */
class FrontendUser extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{

    /**
     * @var bool
     */
    protected $disable = null;

    /**
     * @var string
     */
    protected $company = '';

    /**
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("EmailAddress")
     * @var string
     */
    protected $username = '';

    /**
     * @var string
     */
    protected $password = '';

    /**
     * Virtual field
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup
     */
    protected $group = null;

    /**
     * @var \DateTime
     */
    protected $crdate = null;

    /**
     * @var \DateTime
     */
    protected $tstamp = null;

    /**
     * Virtual field
     *
     * @var Provider|null
     */
    protected $provider = null;

    /**
     * Virtual field
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup
     */
    protected $companyGroup = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $usergroup = null;

    /**
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @var string
     */
    protected $name = '';

    /**
     * passwordResetHash
     *
     * @var string
     */
    protected $passwordResetHash = '';

    /**
     * confirmationSend
     *
     * @var bool
     */
    protected $confirmationSend = false;

    /**
     * termsAndConditionsDate
     *
     * @var \DateTime
     */
    protected $termsAndConditionsDate = null;

    /**
     * @return \DateTime
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * @param \DateTime $tstamp
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * @return \DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param \DateTime $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return UserUtility::getPermissionGroup($this);
    }

    /**
     * @return string
     */
    public function getCompanyGroup()
    {
        return UserUtility::getOrganisationGroup($this);
    }

    /**
     * @return Provider|null
     */
    public function getProvider()
    {
        return UserUtility::getUserProvider($this);
    }

    /**
     * @param FrontendUserGroup $companyGroup
     */
    public function setCompanyGroup($companyGroup)
    {
        $currentGroup = UserUtility::getOrganisationGroup($this);
        foreach ($this->usergroup as $g) {
            if ($currentGroup && $g->getUid() === $currentGroup->getUid()) {
                $this->usergroup->detach($g);
            }
        }
        if ($companyGroup) {
            $this->usergroup->attach($companyGroup);
        }
    }

    /**
     * @param FrontendUserGroup $group
     */
    public function setGroup(FrontendUserGroup $group)
    {
        $permissions = UserUtility::getPermissions();
        foreach ($this->usergroup as $g) {
            if (isset($permissions[$g->getUid()])) {
                $this->usergroup->detach($g);
            }
        }
        $this->usergroup->attach($group);
    }

    /**
     * @param boolean $disable
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;
    }

    /**
     * @return boolean
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getUsergroup()
    {
        return $this->usergroup;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $usergroup
     */
    public function setUsergroup(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $usergroup)
    {
        $this->usergroup = $usergroup;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the passwordResetHash
     *
     * @return string $passwordResetHash
     */
    public function getPasswordResetHash()
    {
        return $this->passwordResetHash;
    }

    /**
     * Sets the passwordResetHash
     *
     * @param string $passwordResetHash
     * @return void
     */
    public function setPasswordResetHash($passwordResetHash)
    {
        $this->passwordResetHash = $passwordResetHash;
    }

    /**
     * Returns the confirmationSend
     *
     * @return bool $confirmationSend
     */
    public function getConfirmationSend()
    {
        return $this->confirmationSend;
    }

    /**
     * Sets the confirmationSend
     *
     * @param bool $confirmationSend
     * @return void
     */
    public function setConfirmationSend($confirmationSend)
    {
        $this->confirmationSend = $confirmationSend;
    }

    /**
     * Returns the boolean state of confirmationSend
     *
     * @return bool
     */
    public function isConfirmationSend()
    {
        return $this->confirmationSend;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
        $setting = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        $this->setPid($setting['chancenportal']['storagePids']['frontend_user']);
    }

    /**
     * Returns the termsAndConditionsDate
     *
     * @return \DateTime $termsAndConditionsDate
     */
    public function getTermsAndConditionsDate()
    {
        return $this->termsAndConditionsDate;
    }

    /**
     * Sets the termsAndConditionsDate
     *
     * @param \DateTime $termsAndConditionsDate
     * @return void
     */
    public function setTermsAndConditionsDate(\DateTime $termsAndConditionsDate)
    {
        $this->termsAndConditionsDate = $termsAndConditionsDate;
    }
}
