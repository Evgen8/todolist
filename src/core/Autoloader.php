<?php
namespace core;

class Autoloader
{
    public static function autoload($className)
    {
        $rootPath = dirname(getcwd());

        $filePath = self::findFilePath($rootPath,$className.'.php');

        if($filePath) {
//            echo "Class file found for $className<br>";
//            echo "$filePath<br>";
            require_once($filePath);
            return class_exists($className,false);
        }

        return false;
    }

    protected static function findFilePath($path,$classFileName)
    {
        $classFileName = str_replace('\\',DIRECTORY_SEPARATOR,$classFileName);
        return $path.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$classFileName;
    }

/**
    protected static function findFilePath($path,$classFileName) {

        $files = scandir($path);

        foreach($files as $file) {
            if('.' == $file[0]) continue;
            if(is_dir($path.DIRECTORY_SEPARATOR.$file)) {
                $filePath = self::findFilePath($path.DIRECTORY_SEPARATOR.$file,$classFileName);
                if($filePath) return $filePath;
            } else {
                if(is_file($path.DIRECTORY_SEPARATOR.$file) && $file == $classFileName) {
                    return $path.DIRECTORY_SEPARATOR.$classFileName;
                }
            }
        }

        return false;
    }
*/
}

spl_autoload_register(['core\Autoloader','autoload']);