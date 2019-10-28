<?php
/**
 * Created by PhpStorm.
 * User: konghy
 * Date: 19-10-28
 * Time: 19-10-28
 */
namespace App\Tools;

/**
 * Class Loader
 * 工厂类
 */
class Loader {

    protected static $class = [];

    /**
     * @param $className
     * @return mixed
     */
    public static function singleton($className) {
        if(!isset(self::$class[$className])) {
            self::$class[$className] = new $className;
        }
        return self::$class[$className];
    }
}