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
parameters:
    gacela:
        modulesNamespace: <base module namespace>
        excludedNamespaces:
            - excluded
            - namespaces

includes:
    - vendor/gacela-project/phpstan-extension/extension.neon
```

### Examples

#### Example without excludedNamespaces

```yaml
parameters:
    gacela:
        modulesNamespace: App\Modules

includes:
    - vendor/gacela-project/phpstan-extension/extension.neon
```

#### Full example

```yaml
parameters:
    gacela:
        modulesNamespace: App\Modules
        excludedNamespaces: 
            - App\Shared

includes:
    - vendor/gacela-project/phpstan-extension/extension.neon
```


## Usage

Run PHPStan as usual. It will additional point out any violations of module boundaries.


