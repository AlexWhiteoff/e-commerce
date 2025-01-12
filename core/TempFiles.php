<?php

namespace core;

class TempFiles
{
    private static $tmpDir;

    /**
     * Initializes the cleanup of the temporary files
     */
    public static function init()
    {
        self::$tmpDir = Configuration::get('paths', 'Paths')['TempDir'];

        if (is_dir(self::$tmpDir)) {
            Logger::log("Starting cleanup of temporary files in " . self::$tmpDir, 'INFO');
            while (true) {
                self::cleaner();
                sleep(1800);
            }
        } else {
            Logger::log("Temporary directory error: The directory " . self::$tmpDir . " does not exist or is unavailable.", 'ERROR');
            return;
        }
    }

    /**
     * Delete temporary files older than 24h
     */
    public static function cleaner()
    {
        if (!is_dir(self::$tmpDir)) {
            Logger::log("Temporary directory error: The directory " . self::$tmpDir . " does not exist or is unavailable.", 'ERROR');
            return;
        }

        $deletedFilesCount = 0;

        foreach (glob(self::$tmpDir . '*') as $file) {
            if (is_file($file) && time() - filemtime($file) > 86400) {
                if (!unlink($file)) {
                    Logger::log("Failed to delete file: $file", 'ERROR');
                } else {
                    Logger::log("Deleted file: $file", 'INFO');
                    $deletedFilesCount++;
                }
            }
        }
        
        Logger::log("Deleted $deletedFilesCount temporary files", 'INFO');
    }

    /**
     * Get temporary directory path
     * @return string
     */
    public static function getTmpDir()
    {
        try {
            if (!is_dir(self::$tmpDir)) {
                Logger::log("Temporary directory error: The directory " . self::$tmpDir . " does not exist or is unavailable.", 'ERROR');
                return null;
            }
            return self::$tmpDir;
        } catch (\Exception $e) {
            Logger::log("Exception while accessing temporary directory: " . $e->getMessage(), 'ERROR');
            return null;
        }
    }
}
