<?php

namespace BlockHandler\Providers;

use Illuminate\Support\ServiceProvider;
use BlockHandler\Factories\BlockHandlerFactory;

class BlockHandlerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BlockHandlerFactory::class, function ($app) {
            $blocksDirectory = $app->path('Blocks');
            return new BlockHandlerFactory($blocksDirectory);
        });
    }
}
