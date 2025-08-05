<?php

declare(strict_types=1);

namespace Ssch\LegacyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;

final class LegacyModelEntity extends AbstractEntity
{
    /**
     * @Validate("NotEmpty")
     */
    protected string $title;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
