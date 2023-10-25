<?php

namespace BlockHandler\Factories;

class BlockHandlerFactory
{
    private $directory;
    private $blocks;

    public function __construct($directory)
    {
        $this->directory = $directory;
        $this->blocks = $this->discoverBlocks();
    }

    private function discoverBlocks()
    {
        $blocks = [];
        $blockFiles = glob($this->directory . '/*.php');

        foreach ($blockFiles as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $key = 'by40q/' . strtolower($filename);
            $class = "\\App\\Blocks\\" . $filename;
            $blocks[$key] = $class;
        }

        return $blocks;
    }

    public function getHandler($blockName)
    {
        return $this->blocks[$blockName] ?? null;
    }
}
