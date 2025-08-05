<?php

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'legacy_extension',
    'web',
    'example',
    'after:info',
    [
        \Ssch\LegacyExtension\Controller\BackendController::class => 'list, detail',
    ],
    [
        'access' => 'admin',
        'workspaces' => 'online',
        'iconIdentifier' => 'module-example',
        'labels' => 'LLL:EXT:legacy_extension/Resources/Private/Language/locallang.xlf',
    ]
);
