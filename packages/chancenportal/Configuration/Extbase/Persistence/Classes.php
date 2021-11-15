<?php

declare(strict_types=1);

return [
    \TYPO3\CMS\Extbase\Domain\Model\FrontendUser::class => [
        'subclasses' => [
            'Tx_Chancenportal_FrontendUser' => \Chancenportal\Chancenportal\Domain\Model\FrontendUser::class
        ]
    ],
    \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup::class => [
        'subclasses' => [
            'Tx_Chancenportal_FrontendUserGroup' => \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup::class
        ]
    ],
    \Chancenportal\Chancenportal\Domain\Model\FrontendUser::class => [
        'tableName' => 'fe_users',
        'recordType' => 'Tx_Chancenportal_FrontendUser'
    ],
    \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup::class => [
        'tableName' => 'fe_groups',
        'recordType' => 'Tx_Chancenportal_FrontendUserGroup'
    ]
];
