<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\Common;

class Utils
{
    /**
     * @return list<string>
     */
    public function asArray(string $string): array
    {
        return [$string];
    }
}
