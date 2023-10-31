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
            $key = 'by40q/' . $this->camelToKebab($filename);
            $class = "\\App\\Blocks\\" . $filename;
            $blocks[$key] = $class;
        }

        return $blocks;
    }

    private function camelToKebab($string) {
        $result = preg_replace('/(?<!^)[A-Z]/', '-$0', $string);
        return strtolower($result);
    }


    public function getHandler($blockName)
    {
        return $this->blocks[$blockName] ?? null;
    }
}
