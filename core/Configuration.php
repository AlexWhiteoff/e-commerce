<?php

namespace core;

class Configuration
{
    private static $configurations = [];

    /**
     * Load configuration file and cache it
     * @param string $fileName
     * @return array
     */
    private static function load(string $fileName)
    {
        if (!isset(self::$configurations[$fileName])) {
            $filePath = realpath(__DIR__ . "/../config/{$fileName}.php");

            if (!$filePath) {
                throw new \Exception("Configuration file '" . __DIR__ . "/../config/{$fileName}.php" . "' not found.");
            }

            self::$configurations[$fileName] = require $filePath;
        }
        return self::$configurations[$fileName];
    }

    /**
     * Get configuration value by file name and key
     * @param string $fileName
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $fileName, string $key)
    {
        $config = self::load($fileName);
        return $config[$key] ?? null;
    }
}
