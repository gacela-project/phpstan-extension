<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Domain;

use GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleB\ModuleBFacadeInterface;

class Person
{
    private ModuleBFacadeInterface $moduleBFacade;

    public function __construct(ModuleBFacadeInterface $moduleBFacade)
    {
        $this->moduleBFacade = $moduleBFacade;
    }

    public function updateName(string $string): void
    {
        $this->moduleBFacade->aMethod();
    }

    public function asString(): string
    {
        return static::class;
    }
}
