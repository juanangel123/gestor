<?php

namespace App\Helpers;

/**
 * Represents the enumerable class
 * Class Enum
 */
abstract class Enum {

    /**
     * @var array
     */
    private static $constantsCache = [];

    /**
     * @var mixed
     */
    private $value;


    /**
     * Enum constructor.
     * @param $value
     */
    public function __construct($value) {
        if (!self::has($value)) {
            throw new \UnexpectedValueException("Value '$value' is not part of the enum " . get_called_class());
        }

        $this->value = $value;
    }


    /**
     * @param $value
     * @return bool
     */
    public function is($value)
    {
        return $this->value === $value;
    }


    /**
     * @return mixed
     */
    public function value() {
        return $this->value;
    }


    /**
     * @param $value
     * @return bool
     */
    public static function has($value) {
        return in_array($value, array_values(self::toArray()));
    }


    /**
     * @return mixed
     */
    public static function toArray() {
        $calledClass = get_called_class();

        if(!array_key_exists($calledClass, self::$constantsCache)) {
            $reflection = new \ReflectionClass($calledClass);
            self::$constantsCache[$calledClass] = $reflection->getConstants();
        }

        return self::$constantsCache[$calledClass];
    }
}