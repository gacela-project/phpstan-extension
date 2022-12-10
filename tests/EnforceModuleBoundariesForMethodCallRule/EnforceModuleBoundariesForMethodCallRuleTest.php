<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule;

use GacelaProject\PhpstanExtension\EnforceModuleBoundariesForMethodCallRule;
use GacelaProject\PhpstanExtension\ExcludedNamespaceChecker;
use GacelaProject\PhpstanExtension\SameLevelModuleComparator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<EnforceModuleBoundariesForMethodCallRule> */
class EnforceModuleBoundariesForMethodCallRuleTest extends RuleTestCase
{
    public function test_method_call_to_code_in_another_module(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/ModuleA/Infrastructure/Command.php',
            ],
            [
                [
                    'Method call to a different module is not allowed. Calling:GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Infrastructure, RefClasses:GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleB\NotAFacade',
                    19,
                ],
            ]
        );
    }

    public function test_method_call_to_code_in_same_module(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/ModuleA/Infrastructure/UpdatePersonCommand.php',
            ],
            [
            ]
        );
    }

    public function test_method_call_to_excluded_namespace(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/ModuleA/Infrastructure/ArrayCommand.php',
            ],
            [
            ]
        );
    }

    public function test_method_call_to_code_from_vendor(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/ModuleA/Infrastructure/PersonRepository.php',
            ],
            [
            ]
        );
    }

    public function test_allow_using_facade_interface_from_other_modules(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/ModuleA/Domain/Person.php',
            ],
            [
            ]
        );
    }

    protected function getRule(): Rule
    {
        return new EnforceModuleBoundariesForMethodCallRule(
            new SameLevelModuleComparator("GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures"),
            new ExcludedNamespaceChecker([
                'GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\Common',
            ])
        );
    }
}
