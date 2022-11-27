# Gacela PHPStan extension

This is a PHPStan extension for Gacela Framework. This enforces module boundaries. 
See (main Gacela project)[https://github.com/gacela-project/gacela] for more information.

## Installation

```bash
composer require --dev gacela-project/phpstan-extension
```

## Configuration

To configure this PHPStan extension you need 2 things.

#### Base module namespace

It is assumed that all your modules are under the same namespace. 
Assume the namespaces for your modules are:

- `Acme\Modules\ModuleA`
- `Acme\Modules\ModuleB` 

The base namespace for your modules is `Acme\Modules`.

#### Excluded namespaces

If you have namespace that hold code that can be used by any module (e.g. `Acme\Shared`), 
then you need to add them to `excludedNamespaces`


### Update PHPStan configuration

Update your project's `phpstan.neon` file:

```yaml
parameters:
    gacela:
        sameLevelModulesNamespace: <base module namespace>
        excludedNamespaces: <excluded namespaces>

includes:
    - vendor/gacela-project/phpstan-extension/extension.neon
```

E.g. 

```yaml
parameters:
    gacela:
        sameLevelModulesNamespace: Acme\Modules
        excludedNamespaces: 
            - Acme\Shared

includes:
    - vendor/gacela-project/phpstan-extension/extension.neon
```


## Usage

Run PHPStan as usual. It will additional point out any violations of module boundaries.


