<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorComposerJson\ChangePackageVersionComposerJsonFractor;
use a9f\FractorComposerJson\RemovePackageComposerJsonFractor;
use a9f\FractorComposerJson\ValueObject\PackageAndVersion;
use a9f\FractorTypoScript\Configuration\TypoScriptProcessorOption;
use a9f\FractorXml\Configuration\XmlProcessorOption;
use a9f\Typo3Fractor\Set\Typo3LevelSetList;
use a9f\Typo3Fractor\TYPO3v10\Yaml\EmailFinisherYamlFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateEmailFlagToEmailTypeFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateItemsIndexedKeysToAssociativeFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateNullFlagFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateRenderTypeColorpickerToTypeColorFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\Fluid\AbstractMessageGetSeverityFluidFractor;
use a9f\Typo3Fractor\TYPO3v13\TypoScript\MigrateIncludeTypoScriptSyntaxFractor;
use a9f\Typo3Fractor\TYPO3v13\TypoScript\RemovePageDoktypeRecyclerFromUserTsConfigFractor;
use a9f\Typo3Fractor\TYPO3v14\Htaccess\RemoveUploadsFromDefaultHtaccessFractor;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinterConditionTermination;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinterConfiguration;

return FractorConfiguration::configure()
    ->withPaths([
        __DIR__ . '/packages/legacy_extension',
        __DIR__ . '/public/.htaccess',
        __DIR__ . '/composer.json',
    ])
    ->withSets([
        Typo3LevelSetList::UP_TO_TYPO3_14
    ])
    ->withConfiguredRule(
        RemovePackageComposerJsonFractor::class,
        [
            'linawolf/list-type-migration', // only relevant for v12
        ]
    )
    ->withConfiguredRule(
        ChangePackageVersionComposerJsonFractor::class,
        [
            new PackageAndVersion('typo3/cms-adminpanel', '^13.4'),
            new PackageAndVersion('typo3/cms-backend', '^13.4'),
            new PackageAndVersion('typo3/cms-belog', '^13.4'),
            new PackageAndVersion('typo3/cms-beuser', '^13.4'),
            new PackageAndVersion('typo3/cms-core', '^13.4'),
            new PackageAndVersion('typo3/cms-dashboard', '^13.4'),
            new PackageAndVersion('typo3/cms-extbase', '^13.4'),
            new PackageAndVersion('typo3/cms-extensionmanager', '^13.4'),
            new PackageAndVersion('typo3/cms-felogin', '^13.4'),
            new PackageAndVersion('typo3/cms-filelist', '^13.4'),
            new PackageAndVersion('typo3/cms-filemetadata', '^13.4'),
            new PackageAndVersion('typo3/cms-fluid', '^13.4'),
            new PackageAndVersion('typo3/cms-fluid-styled-content', '^13.4'),
            new PackageAndVersion('typo3/cms-form', '^13.4'),
            new PackageAndVersion('typo3/cms-frontend', '^13.4'),
            new PackageAndVersion('typo3/cms-info', '^13.4'),
            new PackageAndVersion('typo3/cms-install', '^13.4'),
            new PackageAndVersion('typo3/cms-lowlevel', '^13.4'),
            new PackageAndVersion('typo3/cms-opendocs', '^13.4'),
            new PackageAndVersion('typo3/cms-recordlist', '^13.4'),
            new PackageAndVersion('typo3/cms-recycler', '^13.4'),
            new PackageAndVersion('typo3/cms-redirects', '^13.4'),
            new PackageAndVersion('typo3/cms-reports', '^13.4'),
            new PackageAndVersion('typo3/cms-rte-ckeditor', '^13.4'),
            new PackageAndVersion('typo3/cms-scheduler', '^13.4'),
            new PackageAndVersion('typo3/cms-seo', '^13.4'),
            new PackageAndVersion('typo3/cms-setup', '^13.4'),
            new PackageAndVersion('typo3/cms-tstemplate', '^13.4'),
            new PackageAndVersion('typo3/cms-viewpage', '^13.4'),

            // require-dev
            new PackageAndVersion('ssch/typo3-rector', '^3.6'),
        ]
    )
    ->withOptions([
        XmlProcessorOption::INDENT_CHARACTER => Indent::STYLE_TAB,
        XmlProcessorOption::INDENT_SIZE => 1,
    ])
    ->withOptions([
        TypoScriptProcessorOption::INDENT_SIZE => 4,
        TypoScriptProcessorOption::INDENT_CHARACTER => PrettyPrinterConfiguration::INDENTATION_STYLE_SPACES,
        TypoScriptProcessorOption::ADD_CLOSING_GLOBAL => false,
        TypoScriptProcessorOption::INCLUDE_EMPTY_LINE_BREAKS => true,
        TypoScriptProcessorOption::INDENT_CONDITIONS => true,
        TypoScriptProcessorOption::CONDITION_TERMINATION => PrettyPrinterConditionTermination::Keep,
    ])
    ->withSkip([
        // FlexForm rules
        MigrateEmailFlagToEmailTypeFlexFormFractor::class,
        MigrateItemsIndexedKeysToAssociativeFractor::class,
        MigrateNullFlagFlexFormFractor::class,
        MigrateRenderTypeColorpickerToTypeColorFlexFormFractor::class,

        // TypoScript rules
        MigrateIncludeTypoScriptSyntaxFractor::class,
        RemovePageDoktypeRecyclerFromUserTsConfigFractor::class,

        // .htaccess rules
        RemoveUploadsFromDefaultHtaccessFractor::class,

        // Fluid rules
        AbstractMessageGetSeverityFluidFractor::class,

        // Yaml rules
        EmailFinisherYamlFractor::class,

        // Composer.json rules
        RemovePackageComposerJsonFractor::class,
        ChangePackageVersionComposerJsonFractor::class,
    ]);
