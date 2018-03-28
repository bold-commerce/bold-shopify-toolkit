# Bold Shopify Toolkit

[![CircleCI](https://circleci.com/gh/bold-commerce/bold-shopify-toolkit/tree/master.svg?style=svg)](https://circleci.com/gh/bold-commerce/bold-shopify-toolkit/tree/master)

## Purpose
Bold Shopify Toolkit is a [Symfony](https://symfony.com/)-based [Shopify](https://shopify.com) wrapper that makes it easy to interact with Shopify. The intention is to integrate with the [API offered by Shopify](https://help.shopify.com/api/reference) and maintain consistent data structures for the models and services that access these endpoints.

## Getting Started
This package works best with a Dependency Injection Container since there are many dependencies that need to be resolved.

### Prerequisites
To use this package, you will need to bind Models to the following interfaces.

- [ShopAccessInfo](src/Contracts/ShopAccessInfo.php)
- [ShopBaseInfo](src/Contracts/ShopBaseInfo.php)
- [ApplicationInfo](src/Contracts/ApplicationInfo.php)
- [ApiSleeper](src/Contracts/ApiSleeper.php)

An example API Sleeper has been included in this package.

**Laravel:** (see `AppServiceProvider.php`)

```php
    $this->app->bind(\BoldApps\ShopifyToolkit\Contracts\ApiSleeper::class,
            \BoldApps\ShopifyToolkit\Support\ShopifyApiHandler::class);

```

### Installing

Add to `composer.json`

```sh
$ composer require bold-commerce/bold-shopify-toolkit
```

Bind the appropriate models during your request lifecycle.

```php
    $this->app->bind(\BoldApps\ShopifyToolkit\Contracts\ApiSleeper::class,
            \BoldApps\ShopifyToolkit\Support\ShopifyApiHandler::class);

    ...
```

Bind the shop that will be using the toolkit before making calls to its services and/or models.
```php
// $shop - Eloquent model containing at least the myshopify_domain ("example.myshopify.com")
app()->instance(BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo::class, $shop);
 
// $accessToken - Contains the access token string created when the shop installed the app
app()->instance(BoldApps\ShopifyToolkit\Contracts\ShopAccessInfo::class, $accessToken);
```

## Running the tests

```sh
$ vendor/bin/phpunit tests
```

## Examples

Create the service representing the API you would like to use:
```php
$variantService = new BoldApps\ShopifyToolkit\Services\Variant();
//OR
$variantService = app()->make(BoldApps\ShopifyToolkit\Services\Variant::class);
```

Get a single variant model:
```php
/** @var BoldApps\ShopifyToolkit\Models\Variant $variant */
$variant = $variantService->getById(2641814487051);
 
$variant->getPrice(); //99.0
```

Get a collection of variant models and filter it so that we only get their titles, using the product ID:
```php
/** @var Illuminate\Support\Collection $variants */
$variants = $variantService->getAllByProductId(327661486091, ["fields" => "title"]);
 
/** @var BoldApps\ShopifyToolkit\Models\Variant $variant */
foreach ($variants as $variant) {
    $title = $variant->getTitle(); //"Default title"
}
```

Update a variant:
```php
$variant->setOption1("Not pink");
 
$updatedVariant = $variantService->update($variant);
 
$updatedVariant->getOption1(); //"Not pink"
```

See `tests/VariantTest.php` for an example of how to serialize and deserialize a model.

## TODO

* Add more tests

## Contributing

Pull requests and ideas are welcome! Open an issue and lets talk.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/bold-commerce/bold-shopify-toolkit/tags).

## License

This project is licensed under the Apache 2 License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Thanks to Shopify for making the best Developer Network!
* Thanks to Bold Commerce Developers for making this amazing package
