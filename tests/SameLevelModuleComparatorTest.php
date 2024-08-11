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
            'App\ModuleA\Domain',
            false,
        ];

        yield [
            'App\ModuleA\Domain',
            'Foo/bar',
            false,
        ];

        yield [
            'App\ModuleA\Infrastructure',
            'App\ModuleA\Domain',
            true,
        ];

        yield [
            'App\ModuleA\Infrastructure\Foo',
            'App\ModuleA',
            true,
        ];

        yield [
            'App\ModuleA',
            'App\ModuleA\Infrastructure',
            true,
        ];

        yield [
            'App\ModuleA\Infrastructure',
            'App\ModuleB\Infrastructure',
            false,
        ];

        yield [
            'App\ModuleA\Infrastructure\Person',
            'App\ModuleA\SomeClass',
            true,
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_module_comparator(?string $namespaceA, ?string $namespaceB, bool $expected): void
    {
        $moduleComparator = new SameLevelModuleComparator('App\\');
        $this->assertSame($expected, $moduleComparator->isSameModule($namespaceA, $namespaceB));
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_module_comparator_without_trailing_slash(
        ?string $namespaceA,
        ?string $namespaceB,
        bool $expected,
    ): void {
        $moduleComparator = new SameLevelModuleComparator('App');
        $this->assertSame($expected, $moduleComparator->isSameModule($namespaceA, $namespaceB));
    }

    public function test_is_not_in_module(): void
    {
        $moduleComparator = new SameLevelModuleComparator('App');
        $this->assertFalse($moduleComparator->isInModule('PDO'));
    }

    public function test_is_not_in_module_when_null(): void
    {
        $moduleComparator = new SameLevelModuleComparator('App');
        $this->assertFalse($moduleComparator->isInModule(null));
    }

    public function test_is_in_module(): void
    {
        $moduleComparator = new SameLevelModuleComparator('App\\');
        $this->assertTrue($moduleComparator->isInModule('App\\MyClass'));
    }
}
