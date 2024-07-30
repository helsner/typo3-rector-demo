<?php


$pages = [
    // 'ctrl' => [
    // ],
    'columns' => [
        'doktype' => [
            'config' => [
                // 'type' => 'select',
                'items' => [
                    'custom_pagetypes' => [
                        'custom_pagetypes',
                        '--div--',
                        null,
                        'custom_pagetypes',
                    ],
                    'landingpage' => [
                        'landingpage',
                        'landingpage',
                        'landingpage',
                        'custom_pagetypes',
                    ],
                    // 'custom_pagetypes' => [
                    //     'label' => 'custom_pagetypes',
                    //     'value' => '--div--',
                    //     'icon' => null,
                    //     'group' => 'custom_pagetypes',
                    // ],
                    // 'landingpage' => [
                    //     'label' => 'landingpage',
                    //     'value' => 'landingpage',
                    //     'icon' => 'landingpage',
                    //     'group' => 'custom_pagetypes',
                    // ],
                ],
            ],
        ],
    ],
];
$GLOBALS['TCA']['pages'] = \array_replace_recursive($GLOBALS['TCA']['pages'], $pages);
