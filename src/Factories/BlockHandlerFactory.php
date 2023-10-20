<?php

namespace BlockHandler\Factories;

use BlockHandler\Contracts\BlockHandler;

class BlockHandlerFactory {
    protected $blockMap = [];

    public function __construct(array $blockMap) {
        $this->blockMap = $blockMap;
    }

    public function make($blockName): BlockHandler {
        if (isset($this->blockMap[$blockName])) {
            $className = $this->blockMap[$blockName];
            return new $className;
        }

        throw new \Exception("No handler found for block: {$blockName}");
    }
}
