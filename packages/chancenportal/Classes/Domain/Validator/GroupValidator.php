<?php

namespace Chancenportal\Chancenportal\Domain\Validator;

use Chancenportal\Chancenportal\Domain\Model\FrontendUser;
use Chancenportal\Chancenportal\Utility\UserUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Saltedpasswords\Salt\SaltFactory;


class GroupValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * configurationManager
     *
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    public $configurationManager;
    /**
     * Content Object
     *
     * @var object
     */
    public $cObj;
    /**
     * Plugin Variables
     *
     * @var array
     */
    public $piVars = [];
    /**
     * TypoScript Configuration
     *
     * @var array
     */
    public $configuration = [];
    /**
     * Action Name
     *
     * @var string
     */
    protected $actionName;

    /**
     * @param $user
     * @return bool
     */
    public function isValid($user)
    {
        $this->init();

        $usergroup = UserUtility::getOrganisationGroup($user);
        $currentUser = UserUtility::getCurrentUser();

        if ($currentUser) {
            $isProvider = UserUtility::isProvider($currentUser);
        }

        if (!$currentUser && !$usergroup && empty($this->piVars['user']['company'])) {
            $this->addError('validationErrorPasswordRepeat', 'company', ['field' => 'company']);
            return false;
        } else {

            if ($currentUser && !$usergroup && empty($this->piVars['user']['company']) && empty($this->piVars['user']['companyGroup'])) {
                if (!$isProvider) {
                    $this->addError('validationErrorPasswordRepeat', 'company', ['field' => 'company']);
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Initialize Validator Function
     *
     * @return void
     */
    protected function init()
    {
        $this->configuration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'Chancenportal',
            'Chancenportal'
        );
        $this->cObj = $this->configurationManager->getContentObject();

        $this->piVars = GeneralUtility::_GP('tx_chancenportal_chancenportal');

        $this->actionName = $this->piVars['__referrer']['@action'];
    }
}
