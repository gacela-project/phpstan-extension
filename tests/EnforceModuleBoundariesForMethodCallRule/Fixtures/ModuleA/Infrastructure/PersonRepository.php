<?php

declare(strict_types=1);

namespace GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Infrastructure;

use GacelaProject\PhpstanExtension\Tests\EnforceModuleBoundariesForMethodCallRule\Fixtures\ModuleA\Domain\Person;
use PDO;

final class PersonRepository
{
    public function updatePerson(Person $person): void
    {
        $pdo = new PDO('');
        $pdo->exec('...' . $person->asString());
    }
}
