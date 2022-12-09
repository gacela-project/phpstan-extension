<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleB;

interface ModuleBFacadeInterface
{
    public function aMethod(): void;
}
