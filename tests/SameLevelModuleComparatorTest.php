<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests;

use GacelaProject\PhpstanExtension\SameLevelModuleComparator;
use PHPUnit\Framework\TestCase;

class SameLevelModuleComparatorTest extends TestCase
{
    /**
     * @return iterable<int,array{?string,?string,bool}>
     */
    public function dataProvider(): iterable
    {
        yield [
            null,
            null,
            true,
        ];

        yield [
            null,
            'Foo',
            false,
        ];

        yield [
            'Bar',
            null,
            false,
        ];

        yield [
            'Foo/bar',
            'Foo/bar',
            true,
        ];

        yield [
            'Foo/baz',
            'Foo/bar',
            false,
        ];

        yield [
            'Foo/bar',
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Domain',
            false,
        ];

        yield [
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Domain',
            'Foo/bar',
            false,
        ];

        yield [
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Infrastructure',
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Domain',
            true,
        ];

        yield [
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Infrastructure\Foo',
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA',
            true,
        ];

        yield [
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA',
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Infrastructure',
            true,
        ];

        yield [
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Infrastructure',
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleB\Infrastructure',
            false,
        ];

        yield [
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Infrastructure\Person',
            'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\SomeClass',
            true,
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_module_comparator(?string $namespaceA, ?string $namespaceB, bool $expected): void
    {
        $moduleComparator = new SameLevelModuleComparator('GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\\');
        $this->assertSame($expected, $moduleComparator->isSameModule($namespaceA, $namespaceB));
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_module_comparator_without_trailing_slash(?string $namespaceA, ?string $namespaceB, bool $expected): void
    {
        $moduleComparator = new SameLevelModuleComparator('GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures');
        $this->assertSame($expected, $moduleComparator->isSameModule($namespaceA, $namespaceB));
    }
}
