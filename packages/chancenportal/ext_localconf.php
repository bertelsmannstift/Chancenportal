<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Chancenportal.Chancenportal',
            'Chancenportal',
            [
                'Frontend' => 'searchTeaser, offers, providers, searchOffer, searchProvider',
                'Backend' => 'providerProfile'
            ],
            // non-cacheable actions
            [
                
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    chancenportal {
                        iconIdentifier = chancenportal-plugin-chancenportal
                        title = LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_chancenportal.name
                        description = LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_chancenportal.description
                        tt_content_defValues {
                            CType = list
                            list_type = chancenportal_chancenportal
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'chancenportal-plugin-chancenportal',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:chancenportal/Resources/Public/Icons/user_plugin_chancenportal.svg']
			);
		
    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
$extKey = 'chancenportal';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Chancenportal.Chancenportal',
    'Chancenportal',
    [
        'Frontend' => 'teaser, searchProviderResults, searchProviderResultAjax, providerDetail, offerDetail, providerTeaser, offersTeaser, searchResults, searchResultAjax, searchTeaser, offers, providers, searchOffer, searchProvider',
        'Backend' => 'providerProfile',

        'FrontendUser' => 'loginAs, lostPasswordPage, registerPage, logoutPage, userEditSave, userEditPage, userManagementPage, myDataPage, create, login, logout, loginPage',
        'FrontendUserGroup' => '',
        'MyAccount' => 'evaluationChartTime, evaluationChartPlz, providerPage, adminCompanyProfilePage, adminCompanyProfileSave, exportOffers, evaluations, offerPage, offerPreviewRedirect, offerPreview, newOfferSave, newOfferPage, companyProfilePage, companyProfileSave, overviewPage, providerPreview, providerPreviewRedirect',
    ],
    // non-cacheable actions
    [
        'Provider' => '',
        'FrontendUser' => 'loginAs, lostPasswordPage, registerPage, logoutPage, userEditSave, userEditPage, userManagementPage, myDataPage, create, login, logout, loginPage, create, update',
        'FrontendUserGroup' => 'create, update',
        'MyAccount' => 'evaluationChartTime, evaluationChartPlz, providerPage, adminCompanyProfilePage, adminCompanyProfileSave, exportOffers, evaluations, offerPage, offerPreviewRedirect, offerPreview, newOfferSave, newOfferPage, companyProfilePage, companyProfileSave, overviewPage, providerPreview, providerPreviewRedirect',
        'Frontend' => 'teaser, searchProviderResults, searchProviderResultAjax, providerDetail, offerDetail, providerTeaser, offersTeaser, searchResults, searchResultAjax',
    ]
);

$extbaseObjectContainer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Extbase\Object\Container\Container::class
);
$extbaseObjectContainer->registerImplementation(
    \TYPO3\CMS\Extbase\Persistence\Generic\QueryFactoryInterface::class,
    \Chancenportal\Chancenportal\Persistence\Generic\QueryFactory::class
);

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

$iconRegistry->registerIcon(
    $extKey.'-plugin',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:'.$extKey.'/Resources/Public/Icons/user_plugin_chancenportal.svg']
);

/**
 * Fix broken wizard icons
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
        mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    chancenportal.iconIdentifier = '.$extKey.'-plugin
                }
            }
        }
    ');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'Chancenportal\\Chancenportal\\Hooks\\Backend';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Chancenportal\Chancenportal\Command\Checker::class] = array(
    'extension' => $_EXTKEY,
    'title' => 'E-Mail reminder',
    'description' => 'Erinnerungsmail zu Angeboten ohne Termin (Dauerangebote) an die Anbieter und generelle Erinnerungsmail an die Anbieter.'
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Chancenportal\Chancenportal\Command\UpdateLocation::class] = array(
    'extension' => $_EXTKEY,
    'title' => 'Update offer and provider locations',
    'description' => 'Adresse und Map-Koordinaten mittels Google Maps aktualisieren.'
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Chancenportal\Chancenportal\Command\Slug::class] = array(
    'extension' => $_EXTKEY,
    'title' => 'Update offer and provider slugs',
    'description' => ''
);

if (empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['chancenportal'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['chancenportal'] = [];
}