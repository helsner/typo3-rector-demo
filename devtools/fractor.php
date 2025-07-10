<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\Set\Typo3LevelSetList;

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/../packages/legacy_extension'])
    ->withSets([
        Typo3LevelSetList::UP_TO_TYPO3_13
    ])
;