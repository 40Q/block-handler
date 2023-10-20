<?php

namespace BlockHandler\Providers;

use Illuminate\Support\ServiceProvider;
use BlockHandler\Factories\BlockHandlerFactory;
use Illuminate\Contracts\Config\Repository as Config;

class BlockHandlerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/block-handler.php',
            'block-handler'
        );

        $this->app->singleton(BlockHandlerFactory::class, function ($app) {
            $config = $app->make(Config::class);
            return new BlockHandlerFactory($config->get('block-handler.blocks'));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/block-handler.php' => $this->app->make(Config::class)->get('block-handler')
        ], 'config');
    }
}
