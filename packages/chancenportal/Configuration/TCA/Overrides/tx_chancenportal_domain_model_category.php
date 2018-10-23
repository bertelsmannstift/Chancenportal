<?php

$GLOBALS['TCA']['tx_chancenportal_domain_model_category']['columns']['parent']['onChange'] = 'reload';

$GLOBALS['TCA']['tx_chancenportal_domain_model_category']['columns']['parent']['config']['items'] = [
    ['No parent', 0]
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_category']['columns']['images']['displayCond'] = 'FIELD:parent:=:0';

$GLOBALS['TCA']['tx_chancenportal_domain_model_category']['columns']['children']['config']['appearance'] = [
    'collapseAll' => 1,
    'expandSingle' => 1,
];
$GLOBALS['TCA']['tx_chancenportal_domain_model_category']['columns']['images']['config']['appearance'] = [
    'collapseAll' => 1,
    'expandSingle' => 1,
];

$GLOBALS['TCA']['tx_chancenportal_domain_model_category']['columns']['color']['displayCond'] = [
    'OR' => array(
        'FIELD:parent:=:0',
        'FIELD:parent:=:',
    ),
];


$GLOBALS['TCA']['tx_chancenportal_domain_model_category']['columns']['color']['config'] = [
    'type' => 'input',
    'size' => 10,
    'eval' => 'trim',
    'wizards' => array(
        'colorChoice' => array(
            'type' => 'colorbox',
            'title' => 'Hauptfarbe',
            'module' => array(
                'name' => 'wizard_colorpicker',
            ),
            'JSopenParams' => 'height=600,width=380,status=0,menubar=0,scrollbars=1'
        )
    )
];
