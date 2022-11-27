<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests;

use GacelaProject\PhpstanExtension\ExcludedNamespaceChecker;
use PHPUnit\Framework\TestCase;

class ExcludedNamespaceCheckerTest extends TestCase
{
    private ExcludedNamespaceChecker $excludedNamespaces;

    public function setUp(): void
    {
        $this->excludedNamespaces = new ExcludedNamespaceChecker(
            [
                'Gacela/Common',
                'Gacela/Utils',
            ]
        );
    }

    public function test_in_excluded_namespace(): void
    {
        $this->assertTrue($this->excludedNamespaces->isExcludedNamespace('Gacela/Common/SomeOtherNamespace'));
    }

    public function test_not_in_excluded_namespace(): void
    {
        $this->assertFalse($this->excludedNamespaces->isExcludedNamespace('Gacela/SomeOtherNamespace'));
    }

    public function test_null_value(): void
    {
        $this->assertFalse($this->excludedNamespaces->isExcludedNamespace(null));
    }
}
