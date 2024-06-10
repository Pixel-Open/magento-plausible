<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;

return function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/Block',
        __DIR__ . '/Controller',
        __DIR__ . '/CustomerData',
        __DIR__ . '/Helper',
        __DIR__ . '/Plugin',
        __DIR__ . '/Session',
        __DIR__ . '/view',
    ]);

    // this way you add a single rule
    $ecsConfig->rules([
        NoUnusedImportsFixer::class,
    ]);

    // this way you can add sets - group of rules
    $ecsConfig->sets([
        SetList::SPACES,
        SetList::ARRAY,
        SetList::DOCBLOCK,
        SetList::NAMESPACES,
        SetList::COMMENTS,
        SetList::PSR_12,
        SetList::SYMPLIFY
    ]);

    $ecsConfig->skip([
        NotOperatorWithSuccessorSpaceFixer::class,
        CastSpacesFixer::class
    ]);
};
