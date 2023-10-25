# 40Q Block handler
Handle custom Gutenberg blocks in a Roots/Radicle project

## Installation
1. Install package with composer:
```
composer require 40q/block-handler
```
2. Navigate to `config/app.php`.
3. Find the providers array, and add the service provider class to the end of it.
```php
'providers' => [
    // Other Service Providers...

    BlockHandler\Providers\BlockHandlerServiceProvider::class,
],
```
4. If you want to use the facade without needing to use the fully qualified namespace, add it to the aliases array:
```php
'aliases' => [
    // Other Facades...

    'BlockHandler' => BlockHandler\Facades\BlockHandler::class,
],
```
