# Gacela PHPStan extension — abandoned

> **This package is abandoned. Use [`gacela-project/gacela`](https://github.com/gacela-project/gacela) instead.**
>
> Everything this extension did is built into the framework, and more. It is also
> **incompatible with PHPStan 2**: it builds errors without the identifiers
> PHPStan 2 requires, so it cannot load against the PHPStan version Gacela
> itself needs.

```bash
composer remove --dev gacela-project/phpstan-extension
```

The rules now ship with Gacela, for **PHPStan and Psalm alike**, sharing one
implementation so the two analysers cannot disagree about what counts as a
violation. See
[docs/static-analysis.md](https://github.com/gacela-project/gacela/blob/main/docs/static-analysis.md).

## Migrating

Replace the include:

```neon
# before
includes:
    - vendor/gacela-project/phpstan-extension/extension.neon

# after
includes:
    - vendor/gacela-project/gacela/phpstan-gacela.neon
```

That include turns on the pillar rules — a `*Facade` must extend `AbstractFacade`,
a facade method may only delegate, a factory may not reach for a Facade, a facade
interface must stay in sync — plus real return types for the pillar accessors and
for `getProvidedDependency(Foo::class)`. None of that existed here.

The module-boundary check stays opt-in, because nothing in a class name says
where a boundary falls. Its two parameters are renamed:

| `phpstan-extension` | Gacela |
|---|---|
| `parameters.gacela.modulesNamespace` | `rootNamespace` |
| `parameters.gacela.excludedNamespaces` | `sharedNamespaces` |

```neon
services:
    -
        class: Gacela\PHPStan\Rules\CrossModuleViaFacadeRule
        tags: [phpstan.rules.rule]
        arguments:
            rootNamespace: App\Modules
            sharedNamespaces:
                - App\Shared
    -
        class: Gacela\PHPStan\Rules\CrossModuleMethodCallRule
        tags: [phpstan.rules.rule]
        arguments:
            rootNamespace: App\Modules
            sharedNamespaces:
                - App\Shared
```

`EnforceModuleBoundariesForMethodCallRule` — the one rule this package had — is
`CrossModuleMethodCallRule` there. The check now has a **second half**,
`CrossModuleViaFacadeRule`, which reports the crossings a source writes by name
(`new`, static calls, class constants). This package never covered those.

## Why it moved

The rules describe Gacela's architecture and name `AbstractFacade`,
`AbstractFactory` and the rest. Kept in their own package they fell behind the
framework they check — which is what happened here. Shipped with it, they move in
lockstep and run against Gacela's own source on every build.
