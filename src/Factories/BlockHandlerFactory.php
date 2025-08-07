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
        $distPathUrl = $distPath;
        $distPathFs = str_replace(
            get_theme_file_uri(),
            get_theme_file_path(),
            $distPath
        );

        $manifestPath = $distPathFs . '/manifest.json';

        if (!file_exists($manifestPath)) {
            error_log('Manifest not found: ' . $manifestPath);
            return;
        }

        $jsonString = file_get_contents($manifestPath);
        $manifest = json_decode($jsonString, true);

        if (!is_array($manifest)) {
            error_log('Invalid manifest JSON in: ' . $manifestPath);
            return;
        }

        foreach ($manifest as $key => $file) {
            if (
                (strpos($key, 'blocks/') !== false || strpos($key, 'components/') !== false)
                && strpos($file, '.js') !== false
            ) {
                wp_register_script(
                    str_replace('.js', '', $key),
                    $distPathUrl . '/' . $file
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
