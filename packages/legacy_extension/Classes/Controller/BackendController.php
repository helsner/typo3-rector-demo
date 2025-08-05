<?php

declare(strict_types=1);

namespace Ssch\LegacyExtension\Controller;

use Ssch\LegacyExtension\Service\RandomInterface;
use Ssch\LegacyExtension\Service\TranslatorInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Security\Cryptography\HashService;

/**
 * This file is part of the "https://github.com/sabbelasichon/typo3-rector-demo".
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
final class BackendController extends ActionController
{
    /**
     * Hier steht
     * @var \Ssch\LegacyExtension\Service\MyService
     * @var string
     * @inject
     */
    protected $inject;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RandomInterface
     */
    private $random;

    public function injectTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    public function injectRandom(RandomInterface $random): void
    {
        $this->random = $random;
    }

    public function singleAction(): void
    {
        /** @noRector */
        $logManager = GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager');

        $this->translator->translate('LLL:EXT:legacy_extension/Resources/Private/Language/locallang.xlf:search-text');

        $urlParameters = [
            'edit' => [
                'pages' => [
                    1 => 'edit',
                ],
            ],
            'columnsOnly' => 'title,slug',
            'returnUrl' => $request->getAttribute('normalizedParams')->getRequestUri(),
        ];

        GeneralUtility::makeInstance(UriBuilder::class)->buildUriFromRoute('record_edit', $urlParameters);


        $hashService = GeneralUtility::makeInstance(HashService::class);
        $generatedHash = $hashService->generateHmac('123');
        $isValidHash = $hashService->validateHmac('123', $generatedHash);
        $stringWithAppendedHash = $hashService->appendHmac('123');
        $validatedStringWithHashRemoved = $hashService->validateAndStripHmac($stringWithAppendedHash);

        $getMergedWithPost = GeneralUtility::_GPmerged('tx_scheduler');
    }
}
