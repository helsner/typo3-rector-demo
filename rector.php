<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Set\ValueObject\SetList;
use Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use Rector\ValueObject\PhpVersion;
use Ssch\TYPO3Rector\CodeQuality\General\ExtEmConfRector;
use Ssch\TYPO3Rector\CodeQuality\General\GeneralUtilityMakeInstanceToConstructorPropertyRector;
use Ssch\TYPO3Rector\CodeQuality\General\InjectMethodToConstructorInjectionRector;
use Ssch\TYPO3Rector\Configuration\Typo3Option;
use Ssch\TYPO3Rector\Set\Typo3LevelSetList;
use Ssch\TYPO3Rector\Set\Typo3SetList;
use Ssch\TYPO3Rector\TYPO311\v0\ExtbaseControllerActionsMustReturnResponseInterfaceRector;
use Ssch\TYPO3Rector\TYPO311\v3\MigrateSpecialLanguagesToTcaTypeLanguageRector;
use Ssch\TYPO3Rector\TYPO312\v0\ExtbaseAnnotationToAttributeRector;
use Ssch\TYPO3Rector\TYPO312\v0\MigrateBackendModuleRegistrationRector;
use Ssch\TYPO3Rector\TYPO312\v2\MigrateGeneralUtilityGPMergedRector;
use Ssch\TYPO3Rector\TYPO312\v3\MigrateItemsIndexedKeysToAssociativeRector;
use Ssch\TYPO3Rector\TYPO313\v0\EventListenerConfigurationToAttributeRector;
use Ssch\TYPO3Rector\TYPO313\v0\MigrateExtbaseHashServiceToUseCoreHashServiceRector;
use Ssch\TYPO3Rector\TYPO313\v0\MigrateTypoScriptFrontendControllerSysPageRector;
use Ssch\TYPO3Rector\TYPO313\v2\MigrateTableDependentDefinitionOfColumnsOnlyRector;
use Ssch\TYPO3Rector\TYPO313\v4\MigratePluginContentElementAndPluginSubtypesRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/packages/legacy_extension/',
    ])
    ->withPhpVersion(PhpVersion::PHP_82)
    ->withSets([
        //SetList::CODE_QUALITY,
        //SetList::TYPE_DECLARATION,

        Typo3SetList::CODE_QUALITY,
        // Typo3SetList::GENERAL,
        Typo3LevelSetList::UP_TO_TYPO3_13,
        // To migrate to Doctrine Dbal 4, uncomment the following line
        //\Rector\Doctrine\Set\DoctrineSetList::DOCTRINE_DBAL_40,
    ])
    ->withPHPStanConfigs([Typo3Option::PHPSTAN_FOR_RECTOR_PATH])
    ->withConfiguredRule(ExtEmConfRector::class, [
        ExtEmConfRector::PHP_VERSION_CONSTRAINT => '8.2.0-8.4.99',
        ExtEmConfRector::TYPO3_VERSION_CONSTRAINT => '13.4.0-13.4.99',
        ExtEmConfRector::ADDITIONAL_VALUES_TO_BE_REMOVED => [],
    ])

    // Generate this file with:    TYPO3_CONTEXT=Development vendor/bin/typo3 cache:flush
    ->withSymfonyContainerXml(__DIR__ . '/var/cache/development/App_KernelDevelopmentDebugContainer.xml')

    ->withConfiguredRule(MigrateExtbaseHashServiceToUseCoreHashServiceRector::class, [
        MigrateExtbaseHashServiceToUseCoreHashServiceRector::ADDITIONAL_SECRET => 'devdays2025'
    ])

    // additional rector core rule
    ->withConfiguredRule(ClassPropertyAssignToConstructorPromotionRector::class, [
        'inline_public' => false,
        'rename_property' => true,
        'allow_model_based_classes' => true,
    ])

    ->withConfiguredRule(RenameMethodRector::class, [
        new MethodCallRename('Doctrine\\DBAL\\Connection', 'getSchemaManager', 'createSchemaManager'),
    ])

    ->withSkip([
        // 1. Dry run: vendor/bin/rector -n

        // Demo for: vendor/bin/rector --only="Ssch\TYPO3Rector\CodeQuality\General\GeneralUtilityMakeInstanceToConstructorPropertyRector" -n
        // After running only one rule, you have to clear the cache to see all changes again!
        // vendor/bin/rector --clear-cache -n
        GeneralUtilityMakeInstanceToConstructorPropertyRector::class,

        StaticCallToFuncCallRector::class,

        // Configured rules from Rector Core
        ClassPropertyAssignToConstructorPromotionRector::class,

        // Configured rules from TYPO3 Rector
        ExtEmConfRector::class,

        // Custom Configured Rules
        RenameMethodRector::class,

        // TYPO3 13 rules
        MigrateTypoScriptFrontendControllerSysPageRector::class,
        MigrateTableDependentDefinitionOfColumnsOnlyRector::class,
        MigratePluginContentElementAndPluginSubtypesRector::class,

        // Event listener from Services.yaml to Attribute
        EventListenerConfigurationToAttributeRector::class,

        // Generate new backend module registration file
        MigrateBackendModuleRegistrationRector::class,

        // TCA rules
        MigrateItemsIndexedKeysToAssociativeRector::class,
        MigrateSpecialLanguagesToTcaTypeLanguageRector::class,

        // Extbase rules
        MigrateGeneralUtilityGPMergedRector::class,
        ExtbaseControllerActionsMustReturnResponseInterfaceRector::class,

        // Extbase configured rules
        MigrateExtbaseHashServiceToUseCoreHashServiceRector::class,

        // Code quality rules
        InjectMethodToConstructorInjectionRector::class,

        ExtbaseAnnotationToAttributeRector::class,

        // Rector core rules
        RenameClassRector::class,

        // Finally activate Rector core rule sets
    ]);
