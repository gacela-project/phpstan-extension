<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Infrastructure;

use GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\Common\Utils;

class ArrayCommand
{
    /**
     * @return list<string>
     */
    public function toArray(Utils $utils, string $value): array
    {
        return $utils->asArray($value);
    }
}
