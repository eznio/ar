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
     * Calls provided function on every array's element without altering them
     * @param array $array
     * @param callable $callback
     */
    public static function each($array, $callback)
    {
        foreach ($array as $key => $item) {
            $callback($item, $key);
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
        foreach ($array as $key => $item) {
            if ($callback($item)) {
                $result[$key] = $item;
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
        foreach ($array as $key => $item) {
            if (!$callback($item)) {
                $result[$key] = $item;
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
        foreach ($array as $key => $item) {
            $response = $callback($item, $key);
            if (is_array($response)) {
                $result[current(array_keys($response))] = current(array_values($response));
            } else {
                $result[$key] = $response;
            }
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

    /**
     * Sorts array comparing elements given in Ar::get() notattion (level1.level2.level3.etc)
     * @param $array
     * @param $element
     * @return array
     */
    public static function sort($array, $element) {
        usort($array, function($item1, $item2) use ($element) {
            if (Ar::get($item1, $element) > Ar::get($item2, $element)) {
                return 1;
            } elseif (Ar::get($item1, $element) == Ar::get($item2, $element)) {
                return 0;
            } else {
                return -1;
            }
        });
        return $array;
    }

    /**
     * Checks if
     *  a. array is given
     *  b. it doesn't contain any other arrays as elements
     * @param $array
     * @return bool
     */
    public static function is1d($array) {
        return is_array($array) ? Ar::reduce($array, function($element, $initial) {
            return $initial && !is_array($element);
        }, true) : false;

    }

    /**
     * Checks if
     *  a. array is given
     *  b. it contains only arrays as elements
     *  c. those arrays doesn't contain child arrays
     * @param $array
     * @return bool
     */
    public static function is2d($array) {
        return is_array($array) ? Ar::reduce($array, function($element, $initial) {
            return $initial && Ar::is1d($element);
        }, true) : false;
    }
}