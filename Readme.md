# 40Q Block handler
Handle custom Gutenberg blocks in a Roots/Radicle project

## Installation
1. Navigate to `config/app.php`.
2. Find the providers array, and add the service provider class to the end of it.
```php
'providers' => [
    // Other Service Providers...

    BlockHandler\Providers\BlockHandlerServiceProvider::class,
],
```
3. If you want to use the facade without needing to use the fully qualified namespace, add it to the aliases array:
```php
'aliases' => [
    // Other Facades...

    'BlockHandler' => BlockHandler\Facades\BlockHandler::class,
],
```