<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\Tests\ModuleA\Domain;

use GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Domain\Person;
use GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleB\ModuleBFacadeInterface;
use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{
    public function test_something(): void
    {
        $p = new Person(
            $this->createStub(ModuleBFacadeInterface::class),
        );

        self::assertEquals($p::class, $p->asString());
    }
}
