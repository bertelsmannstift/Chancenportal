<?php

namespace UI\UiProvider\Ajax;

use \TYPO3\CMS\Core\Utility\GeneralUtility;

class Version {

    const DEFAULT_SITEMAP_TYPE = 'pages';
    /**
     * Main function of the class. Outputs sitemap.
     *
     * @return	void
     */
    public function main() {
        if(GeneralUtility::_GP('token') === 'u_i_get_version') {
            echo TYPO3_version;
        } else {
            header('HTTP/1.0 404 Page not found', true, 404);
            header('Content-type: text/plain');
            echo 'Page not found';
        }
    }
}

$generator = GeneralUtility::makeInstance('UI\\UiProvider\\Ajax\\Version');
/* @var EntryPoint $generator */
$generator->main();