<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension;

use Gacela\Framework\AbstractFacade;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;

/** @implements Rule<\PhpParser\Node\Expr\MethodCall> */
final class EnforceModuleBoundariesForMethodCallRule implements Rule
{
    private ModuleComparator $moduleComparator;
    private ExcludedNamespaceChecker $excludedNamespaceChecker;

    public function __construct(
        ModuleComparator $moduleComparator,
        ExcludedNamespaceChecker $excludedNamespaceChecker
    ) {
        $this->moduleComparator = $moduleComparator;
        $this->excludedNamespaceChecker = $excludedNamespaceChecker;
    }

    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    /**
     * @param \PhpParser\Node\Expr\MethodCall $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        // 1. Is the object we are calling a facade? If yes then exit.
        $type = $scope->getType($node->var);
        $facadeObjectType = new ObjectType(AbstractFacade::class);
        if ($facadeObjectType->isSuperTypeOf($type)->yes()) {
            return [];
        }

        // 2. Is this a call to code in the same module. If yes then exit.
        // 3. Or is this a call to code in an excluded namespace. If yes then exit.
        $namespaceOfCallingCode = $scope->getNamespace();
        foreach ($type->getReferencedClasses() as $referencedClass) {
            if ($this->moduleComparator->isSameModule($namespaceOfCallingCode, $referencedClass)) {
                return [];
            }

            if ($this->excludedNamespaceChecker->isExcludedNamespace($referencedClass)) {
                return [];
            }
        }

        // 4. Raise an error.
        return [
            RuleErrorBuilder::message('Method call to a different module is not allowed.')->build(),
        ];
    }
}
