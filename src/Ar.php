<?php

namespace eznio\ar;

class Ar
{
    /**
     * Error-safe recursive array item getter
     * Translates path "a.b.c" to 'a' => ['b' => ['c' => ... ]]]
     * @param array $array
     * @param string $path
     * @return mixed
     */
    public static function get($array, $path)
    {
        $path = explode('.', $path);
        foreach ($path as $item) {
            if (!is_array($array) || !array_key_exists($item, $array)) {
                return null;
            }
            $array = $array[$item];
        }
        return $array;
    }

    /**
     * Calls provided function on every array's element
     * @param array $array
     * @param callable $callback
     */
    public static function each($array, $callback)
    {
        foreach ($array as $item) {
            $callback($item);
        }
    }

    /**
     * Filters array into new one using function to decide which elements to keep
     * @param array $array
     * @param callable $callback
     * @return array
     */
    public static function filter($array, $callback)
    {
        $result = [];
        foreach ($array as $item) {
            if ($callback($item)) {
                $result[] = $item;
            }
        }
        return $result;
    }

    /**
     * Filters array into new one using function to decide which elements to drop
     * @param array $array
     * @param callable $callback
     * @return array
     */
    public static function reject($array, $callback)
    {
        $result = [];
        foreach ($array as $item) {
            if (!$callback($item)) {
                $result[] = $item;
            }
        }
        return $result;
    }

    /**
     * Processes every array element with provided function and stores it's result in a new array
     * @param array $array
     * @param callable $callback
     * @return array
     */
    public static function map($array, $callback)
    {
        $result = [];
        foreach ($array as $item) {
            $result[] = $callback($item);
        }
        return $result;
    }

    /**
     * Reduces array into scalar value using provided function
     * @param array $array
     * @param callable $callback function($item, $currentValue)
     * @param mixed $initialValue
     * @return mixed
     */
    public static function reduce($array, $callback, $initialValue = null)
    {
        $currentValue = $initialValue;
        foreach ($array as $item) {
            $currentValue = $callback($item, $currentValue);
        }
        return $currentValue;
    }
}