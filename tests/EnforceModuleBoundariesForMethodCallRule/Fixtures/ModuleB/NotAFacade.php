<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleB;

class NotAFacade
{
    public function anotherMethod(): void
    {
    }
}
