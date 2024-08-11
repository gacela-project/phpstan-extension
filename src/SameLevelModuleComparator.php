<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension;

use function strlen;

class SameLevelModuleComparator implements ModuleComparator
{
    private string $modulesNamespace;

    public function __construct(
        string $modulesNamespace,
    ) {
        $this->modulesNamespace = rtrim($modulesNamespace, '\\') . '\\';
    }

    public function isInModule(?string $namespace): bool
    {
        if ($namespace === null) {
            return false;
        }

        return $this->isModulesNamespace($namespace);
    }

    public function isSameModule(?string $namespaceA, ?string $namespaceB): bool
    {
        if ($namespaceA === $namespaceB) {
            return true;
        }

        if ($namespaceA === null || $namespaceB === null) {
            return false;
        }

        if (!$this->isModulesNamespace($namespaceA)) {
            return false;
        }

        if (!$this->isModulesNamespace($namespaceB)) {
            return false;
        }

        $moduleA = $this->getModule($namespaceA);
        $moduleB = $this->getModule($namespaceB);

        return ($moduleA === $moduleB);
    }

    private function isModulesNamespace(string $namespace): bool
    {
        return strpos($namespace, $this->modulesNamespace) === 0;
    }

    private function getModule(string $namespace): string
    {
        $module = substr($namespace, strlen($this->modulesNamespace));

        return substr($module, 0, strpos($module, '\\') ?: strlen($module));
    }
}
