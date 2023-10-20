<?php

namespace BlockHandler\Facades;

use Illuminate\Support\Facades\Facade;

class BlockHandler extends Facade {
    protected static function getFacadeAccessor() {
        return \BlockHandler\Factories\BlockHandlerFactory::class;
    }
}
