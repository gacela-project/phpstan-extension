<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA;

use Gacela\Framework\AbstractFacade;

class EntryPoint extends AbstractFacade
{
    public function entryPointMethod(): void
    {
    }
}
