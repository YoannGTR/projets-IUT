<?php


class Autoloader
{
    public static function autoload($className)
    {
        // Define the base directory for the namespace prefix
        $baseDir = __DIR__ . '/';

        // Remove the namespace prefix and replace with the base directory
        $className = str_replace('\\', '/', $className);
        $file = $baseDir . $className . '.php';

        // If the file exists, require it
        if (file_exists($file)) {
            require $file;
        }
    }
}

spl_autoload_register('Autoloader::autoload');