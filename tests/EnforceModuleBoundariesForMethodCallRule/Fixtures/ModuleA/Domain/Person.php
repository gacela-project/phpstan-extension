<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Domain;

use function get_class;

class Person
{
    public function updateName(string $string): void
    {
    }

    public function asString(): string
    {
        return get_class($this);
    }
}
