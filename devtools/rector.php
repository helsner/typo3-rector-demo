<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\PostRector\Rector\NameImportingPostRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\ValueObject\PhpVersion;
use Ssch\TYPO3Rector\CodeQuality\General\ConvertImplicitVariablesToExplicitGlobalsRector;
use Ssch\TYPO3Rector\CodeQuality\General\ExtEmConfRector;
use Ssch\TYPO3Rector\Configuration\Typo3Option;
use Ssch\TYPO3Rector\Set\Typo3LevelSetList;
use Ssch\TYPO3Rector\Set\Typo3SetList;
use Ssch\TYPO3Rector\TYPO313\v0\EventListenerConfigurationToAttributeRector;

return RectorConfig::configure()
    ->withPaths([
        // __DIR__ . '/../packages/',
        __DIR__ . '/../packages/legacy_extension/',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withPhpVersion(PhpVersion::PHP_82)
    ->withSets([
        // Typo3SetList::CODE_QUALITY,
        // Typo3SetList::GENERAL,
        Typo3LevelSetList::UP_TO_TYPO3_13,
        // To migrate to Doctrine Dbal 4, uncomment the following line
        //\Rector\Doctrine\Set\DoctrineSetList::DOCTRINE_DBAL_40,
    ])
    // To have a better analysis from PHPStan, we teach it here some more things
    ->withPHPStanConfigs([Typo3Option::PHPSTAN_FOR_RECTOR_PATH])
    ->withRules([
        // AddVoidReturnTypeWhereNoReturnRector::class,
        // ConvertImplicitVariablesToExplicitGlobalsRector::class,
        // EventListenerConfigurationToAttributeRector::class,
    ])
    // ->withConfiguredRule(ExtEmConfRector::class, [
    //     ExtEmConfRector::PHP_VERSION_CONSTRAINT => '8.2.0-8.4.99',
    //     ExtEmConfRector::TYPO3_VERSION_CONSTRAINT => '13.4.0-13.4.99',
    //     ExtEmConfRector::ADDITIONAL_VALUES_TO_BE_REMOVED => [],
    // ])
    // If you use withImportNames(), you should consider excluding some TYPO3 files.
    ->withSkip([
        // @see https://github.com/sabbelasichon/typo3-rector/issues/2536
        __DIR__ . '/**/Configuration/ExtensionBuilder/*',
        NameImportingPostRector::class => [
            'ClassAliasMap.php',
        ]
    ])

    ->withSymfonyContainerXml(__DIR__ . '/../var/cache/development/App_KernelDevelopmentDebugContainer.xml')

    // ->withConfiguredRule(\Ssch\TYPO3Rector\TYPO313\v0\MigrateExtbaseHashServiceToUseCoreHashServiceRector::class, [
    //     \Ssch\TYPO3Rector\TYPO313\v0\MigrateExtbaseHashServiceToUseCoreHashServiceRector::ADDITIONAL_SECRET => 'devdays2025'
    // ])

    // additional rector core rule
    // ->withConfiguredRule(ClassPropertyAssignToConstructorPromotionRector::class, [
    //     'inline_public' => false,
    //     'rename_property' => true,
    //     'allow_model_based_classes' => true,
    // ])

    ->withConfiguredRule(RenameMethodRector::class, [
        // @see https://github.com/doctrine/dbal/blob/4.0.x/UPGRADE.md#bc-break-removed-connection_schemamanager-and-connectiongetschemamanager
        new MethodCallRename('Doctrine\\DBAL\\Connection', 'getSchemaManager', 'createSchemaManager'),
    ])
;
