# Gacela PHPStan extension

This is a PHPStan extension for Gacela Framework. This enforces module boundaries.

See [main Gacela project](https://github.com/gacela-project/gacela) for more information.

## Installation

```bash
composer require --dev gacela-project/phpstan-extension
```

## Configuration

To configure this PHPStan extension you need 2 things.

#### Base module namespace

It is assumed that all your modules are under the same namespace. 
Assume the namespaces for your modules are:

- `App\Modules\ModuleA`
- `App\Modules\ModuleB` 

The base namespace for your modules is `App\Modules`.

#### Excluded namespaces (Optional)

If you have namespace that hold code that can be used by any module (e.g. `App\Shared`), 
then you need to add them to `excludedNamespaces`. Default: `[]`.


### Update PHPStan configuration

Update your project's `phpstan.neon` file:

```yaml
includes:
  - vendor/gacela-project/phpstan-extension/extension.neon

parameters:
    gacela:
        modulesNamespace: <base module namespace>
        excludedNamespaces:
            - excluded
            - namespaces
```

### Examples

#### Example without excludedNamespaces

```yaml
includes:
  - vendor/gacela-project/phpstan-extension/extension.neon

parameters:
    gacela:
        modulesNamespace: App\Modules
```

#### Full example

```yaml
includes:
  - vendor/gacela-project/phpstan-extension/extension.neon

parameters:
    gacela:
        modulesNamespace: App\Modules
        excludedNamespaces: 
            - App\Shared
```

## Usage

Run PHPStan as usual. It will additional point out any violations of module boundaries.


