<?php

/**
 *
 * Additional Configurations
 *
 **/

$envFile = __DIR__ . '/../../../.env';
if (file_exists($envFile)) {
    (new Dotenv\Dotenv(dirname($envFile)))->load();
}

$currentApplicationContext = \TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->__toString();
$configPath = realpath(__DIR__) . '/../../configuration/';

$file = $configPath . 'Default.php';
if(is_file($file)) {
    include_once($file);
}

$file = $configPath . str_replace('/', '', $currentApplicationContext) . '.php';
if(is_file($file)) {
    include_once($file);
}

/**
 * Database Credentials
 */
if(getenv('TYPO3_DB_HOST')) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'] = getenv('TYPO3_DB_HOST');
}

if(getenv('TYPO3_DB_PORT')) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['port'] = getenv('TYPO3_DB_PORT');
}

if(getenv('TYPO3_DB_NAME')) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'] = getenv('TYPO3_DB_NAME');
}

if(getenv('TYPO3_DB_USER')) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'] = getenv('TYPO3_DB_USER');
}

if(getenv('TYPO3_DB_PASSWORD')) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = getenv('TYPO3_DB_PASSWORD');
}

/**
 * Mail SMTP Credentials
 */
if(getenv('TYPO3_MAIL_TRANSPORT') && getenv('TYPO3_MAIL_TRANSPORT') === 'smtp') {
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';

    if(getenv('TYPO3_MAIL_SMTP_SERVER')) {
        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = getenv('TYPO3_MAIL_SMTP_SERVER');
    }

    if(getenv('TYPO3_MAIL_SMTP_USERNAME')) {
        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = getenv('TYPO3_MAIL_SMTP_USERNAME');
    }

    if(getenv('TYPO3_MAIL_SMTP_PASSWORD')) {
        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = getenv('TYPO3_MAIL_SMTP_PASSWORD');
    }

    if(getenv('TYPO3_MAIL_SMTP_ENCRYPT')) {
        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = getenv('TYPO3_MAIL_SMTP_ENCRYPT');
    }
}

/**
 * TYPO3
 */
if(getenv('TYPO3_BE_INSTALLTOOLPASSWORD')) {
    $GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword'] = getenv('TYPO3_BE_INSTALLTOOLPASSWORD');
}
