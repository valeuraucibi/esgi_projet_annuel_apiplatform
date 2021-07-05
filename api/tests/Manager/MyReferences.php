<?php

namespace App\Tests\Manager;

class MyReferences {
    public static $references = [];

    public static function getReferences() {
        return self::$references;
    }
    public static function getReference($index) {
        return self::$references[$index] ?? null;
    }
    public static function addReference($index, $value)
    {
        self::$references[$index] = $value;
    }
}
