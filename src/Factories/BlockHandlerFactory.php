<?php

namespace BlockHandler\Factories;

class BlockHandlerFactory
{
    private $directory;
    private $blocks;

    public function __construct($directory, $distPath)
    {
        $this->directory = $directory;
        $this->blocks = $this->discoverBlocks();
        $this->registerScripts($distPath);
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

    private function camelToKebab($string)
    {
        $result = preg_replace('/(?<!^)[A-Z]/', '-$0', $string);
        return strtolower($result);
    }

    private function registerScripts($distPath)
    {
        $jsonString = file_get_contents($distPath . '/manifest.json');
        $manifest = json_decode($jsonString, true);

        foreach ($manifest as $key => $file) {
            if ((strpos($key, 'blocks/') !== false || strpos($key, 'components/') !== false) && strpos($file, '.js') !== false) {
                wp_register_script(
                    str_replace('.js', '', $key),
                    $distPath . '/' . $file
                );
            }
        }
    }

    public function getHandler($blockName)
    {
        return $this->blocks[$blockName] ?? null;
    }

    public function getBlocks()
    {
        return $this->blocks;
    }
}
