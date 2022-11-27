<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension;

interface ModuleComparator
{
    public function isSameModule(?string $namespaceA, ?string $namespaceB): bool;
}
