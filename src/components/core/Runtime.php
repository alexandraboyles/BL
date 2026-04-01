<?php
namespace Core;

class Runtime {
    public static function fileExists($filePath, $context = null) {
        if (!file_exists($filePath)) {
            throw new RuntimeException("File does not exist: $filePath", $context ?? $filePath);
        }
        return $filePath;
    }

    public static function directoryExists($dirPath, $context = null) {
        if (!is_dir($dirPath)) {
            throw new RuntimeException("Directory does not exist: $dirPath", $context ?? $dirPath);
        }
        return $dirPath;
    }

    public static function writable($path, $context = null) {
        if (!is_writable($path)) {
            throw new RuntimeException("Path is not writable: $path", $context ?? $path);
        }
        return $path;
    }

    public static function notNull($value, $fieldName) {
        if ($value === null) {
            throw new RuntimeException("$fieldName cannot be null", $fieldName);
        }
        return $value;
    }

    public static function validConfig($config, $requiredKeys) {
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new RuntimeException("Missing required config key: $key", "config");
            }
        }
        return $config;
    }
}

