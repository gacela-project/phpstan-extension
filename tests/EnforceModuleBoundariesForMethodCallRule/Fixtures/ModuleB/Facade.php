<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleB;

use Gacela\Framework\AbstractFacade;

class Facade extends AbstractFacade
{
    public function aMethod(): void
    {
    }
}
