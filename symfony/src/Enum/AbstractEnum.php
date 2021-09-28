<?php

namespace App\Enum;

abstract class AbstractEnum {
    public static function getConstants() {
        $calledClass = get_called_class();
        $reflect = new \ReflectionClass($calledClass);

        return $reflect->getConstants();
    }

    public static function isValidName($name, $strict = false) {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));

        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true) {
        $values = array_values(self::getConstants());

        return in_array($value, $values, $strict);
    }
}