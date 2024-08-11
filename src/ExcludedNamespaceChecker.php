<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension;

class ExcludedNamespaceChecker
{
    /** @var list<string> */
    private array $excludedNamespaces;

    /**
     * @param list<string> $excludedNamespaces
     */
    public function __construct(
        array $excludedNamespaces,
    ) {
        $this->excludedNamespaces = $excludedNamespaces;
    }

    public function isExcludedNamespace(?string $namespaceOrClass): bool
    {
        if ($namespaceOrClass === null) {
            return false;
        }

        foreach ($this->excludedNamespaces as $excludedNamespace) {
            if (strpos($namespaceOrClass, $excludedNamespace) === 0) {
                return true;
            }
        }

        return false;
    }
}
