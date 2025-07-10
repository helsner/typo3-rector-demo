<?php

declare(strict_types=1);

namespace Ssch\LegacyExtension\EventListener;

use TYPO3\CMS\Core\Mail\Event\AfterMailerInitializationEvent;

final class ExampleListener
{
    public function __invoke(AfterMailerInitializationEvent $event): void
    {
    }
}