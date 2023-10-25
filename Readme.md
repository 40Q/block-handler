# 40Q Block handler
Handle custom Gutenberg blocks in a Roots/Radicle project

## Installation
1. Install package with composer:
```
composer require 40q/block-handler
```
2. Find the providers array in `config/app.php`, and add the service provider class to the end of it.
```php
'providers' => [
    // Other Service Providers...

    BlockHandler\Providers\BlockHandlerServiceProvider::class,
],
```
3. Use the package in `BlocksServiceProvider.php`
```php
add_filter('render_block', function ($block_content, $block) {
    try {
        $factory = app(BlockHandler::class);
        $handlerClass = $factory->getHandler($block['blockName']);

        if ($handlerClass) {
            $handlerInstance = new $handlerClass();
            return $handlerInstance($block_content, $block);
        }
    } catch (\Exception $e) {
        error_log($e->getMessage());
    }

    return $block_content;
}, 10, 2);
```
4. Create a `Blocks` folder inside `app` and put your handlers inside.

## Block handlers
The package will try to use each file inside `app\Blocks` as a block handler. In order for this to work as expected, make sure all classes follow the `BlockHandler` contract.

Blocks with their block handlers can be generated with the [40q cli tool](https://github.com/40Q/40q-cli):
```
40q codegen block
```

**Example:**

```php
<?php

namespace App\Blocks;
use BlockHandler\Contracts\BlockHandler;

class Modal implements BlockHandler {
    public function __invoke($block_content, $block) {
        return view('blocks.modal', [
            'block' => $block,
            'blockContent' => $block_content,
            'buttonText' => $block['attrs']['buttonText'] ?? null,
            'heading' => $block['attrs']['heading'] ?? null,
        ]);
    }
}
```
