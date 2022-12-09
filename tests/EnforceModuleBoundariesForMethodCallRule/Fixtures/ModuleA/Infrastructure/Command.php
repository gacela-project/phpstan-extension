<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Infrastructure;

use GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleB\ModuleBFacade;
use GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleB\NotAFacade;

class Command
{
    public function allowedMethodCall(ModuleBFacade $facade): void
    {
        $facade->aMethod(); // This is allowed
    }

    public function notAllowedMethodCall(NotAFacade $notAFacade): void
    {
        $notAFacade->anotherMethod(); // This is not allowed
    }
}
