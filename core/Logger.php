<?php

namespace core;

/**
 * Class that is used to log messages
 */
class Logger
{
    private static $logFile;

    public static function init()
    {
        self::$logFile = Configuration::get('paths', 'Files')['SystemLog'];

        if (!realpath(self::$logFile)) {
            $logFileDir = Configuration::get('paths', 'Paths')['LogDir'];

            if (!is_dir($logFileDir)) {
                mkdir($logFileDir, 0755, true);
            }

        }
    }

    /**
     * Logs a message
     * @param string $message Message to log
     * @param array $level Log level (ERROR, INFO, WARNING)
     */
    public static function log($message, $level = 'INFO')
    {
        if (empty(self::$logFile)){
            self::init();
        }

        $timestamp = date('Y-m-d H:i:s');
        $formattedMessage = "[$timestamp] [$level] [$message]" . PHP_EOL;

        error_log($formattedMessage, 3, self::$logFile);
    }

    /**
     * Get the last N lines from the log file
     * @param int $lines number of lines to get
     * @return array last N lines from the log file
     */
    public static function getLogs($lines = 100)
    {
        if (!file_exists(self::$logFile)) {
            return ["Log file does not exist."];
        }

        $fileContent = file(self::$logFile);
        return array_slice($fileContent, -$lines);
    }

    /**
     * Clears the log file
     */
    public static function clearLog()
    {
        if (file_exists(self::$logFile)) {
            file_put_contents(self::$logFile, '');
        }
    }
}
