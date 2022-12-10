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
     *
     * @return list<\PHPStan\Rules\RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $type = $scope->getType($node->var);
        $facadeObjectType = new ObjectType(AbstractFacade::class);
        // Is the object we are calling a facade? If yes then exit.
        if ($facadeObjectType->isSuperTypeOf($type)->yes()) {
            return [];
        }

        $namespaceOfCallingCode = $scope->getNamespace();
        foreach ($type->getReferencedClasses() as $referencedClass) {
            if (strpos($referencedClass, 'FacadeInterface') !== false) {
                return [];
            }

            // Is this a call to code in the same module. If yes then exit.
            if ($this->moduleComparator->isSameModule($namespaceOfCallingCode, $referencedClass)) {
                return [];
            }

            // Is this a call to code in an excluded namespace. If yes then exit.
            if ($this->excludedNamespaceChecker->isExcludedNamespace($referencedClass)) {
                return [];
            }

            // Is the code from outside the app (core or vendor)? If yes then exit.
            if (!$this->moduleComparator->isInModule($referencedClass)) {
                return [];
            }
        }

        $message = sprintf(
            'Method call to a different module is not allowed. Calling:%s, RefClasses:%s',
            $namespaceOfCallingCode ?? 'null',
            implode(',', $type->getReferencedClasses())
        );

        return [
            RuleErrorBuilder::message($message)->build(),
        ];
    }
}
