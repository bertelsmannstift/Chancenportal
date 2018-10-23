<?php

namespace Chancenportal\Chancenportal\Domain\Validator;

use Chancenportal\Chancenportal\Utility\UserUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Saltedpasswords\Salt\SaltFactory;


class UserValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * configurationManager
     *
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
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
     * providerRepository
     *
     * @var \Chancenportal\Chancenportal\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository = null;

    /**
     * @param $user
     * @return bool
     */
    public function isValid($user)
    {
        $this->init();

        if ($user) {

            $objInstanceSaltedPw = SaltFactory::getSaltingInstance();

            $newUsername = isset($this->piVars['new_username']) ? $this->piVars['new_username'] : '';
            $password = isset($this->piVars['password']) ? $this->piVars['password'] : '';
            $passwordRepeat = isset($this->piVars['password_repeat']) ? $this->piVars['password_repeat'] : '';

            $newPassword = isset($this->piVars['new_password']) ? $this->piVars['new_password'] : null;
            $newPasswordRepeat = isset($this->piVars['new_password_repeat']) ? $this->piVars['new_password_repeat'] : null;

            if($newUsername !== $user->getUsername()) {
                if($this->frontendUserRepository->findOneByUsername($newUsername)) {
                    $this->addError('validationErrorUsernameExists', 'new_username');
                    return false;
                } elseif(filter_var($newUsername, FILTER_VALIDATE_EMAIL) !== false) {
                    $user->setUsername($newUsername);
                }
            }

            if ($user->getUid() && !empty($password)) {
                // edit user

                if ($objInstanceSaltedPw->checkPassword($password, $user->getPassword())) {

                    if (empty($newPassword) || strlen($newPassword) < 7) {
                        $this->addError('validationErrorPasswordRepeat', 'new_password');
                        return false;
                    } else {
                        if (empty($newPassword) || $newPassword !== $newPasswordRepeat) {
                            $this->addError('validationErrorPasswordRepeat', 'new_password_repeat');
                            return false;
                        }
                    }
                } else {
                    $this->addError('validationErrorPasswordRepeat', 'password');
                    return false;
                }

                $user->setPassword($objInstanceSaltedPw->getHashedPassword($newPassword));

            } elseif (!$user->getUid()) {

                // new user
                if ($password !== $passwordRepeat) {
                    $this->addError('validationErrorPasswordRepeat', 'password_repeat');
                    return false;
                } else {
                    if (strlen($password) < 7) {
                        $this->addError('validationErrorPasswordRepeat', 'password');
                        return false;
                    }
                }

                $user->setPassword($objInstanceSaltedPw->getHashedPassword($password));
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
