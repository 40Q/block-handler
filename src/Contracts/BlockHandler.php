<?php

namespace BlockHandler\Contracts;

interface BlockHandler {
    public function __invoke($block_content, $block);
}
