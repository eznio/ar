# Some simple array shortcuts

Small collection of (sometimes) useful array-related tools.

```php
function get(array $array, string $path);
function each(array $array, callable $callback)
function filter(array $array, callable $callback)
function reject(array $array, callable $callback)
function map(array $array, callable $callback)
function reduce(array $array, callable $callback, mixed $initialValue)
function sort(array $array, string $elementPath)
function is1d(array $array)
function is2d(array $array)
```

Documentation: https://eznio.github.io/ar/