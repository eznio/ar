# Some simple array shortcuts
This library is mostly intended for my projects' internal use, you've been warned :)

## Ar::get()

~~~
function get(array $array, string $path);
~~~

This is used for error-free getting deep nested array value:

~~~
$array = ['a' => ['b' => ['c' => 'value']]]

$result = Ar::get($array, 'a.b.c'); // 'value'

$result = Ar::get($array, 'a.b'); // ['c' => 'value']

$result = Ar::get($array, 'non.existent.path'); // null
~~~

## Ar::each()

~~~
function each(array $array, callable $callback)
~~~

~~~
$callback = function(mixed $item) : void {}
~~~

Runs given function on every array element. Does not store any returned values.

~~~
$usersToDelete = $usersModel->getUsersToDelete();
Ar::each($usersToDelete, function($user) {
    $user->delete();
});
~~~

## Ar::filter()

~~~
function filter(array $array, callable $callback)
~~~

~~~
$callback = function(mixed $item) : bool {}
~~~

Filters array using provided function to decide if element should be stored (true) or dropped (false).

~~~
$usersToSendEmail = $usersModel->getUsersToSendEmail();
$usersWithEmails = Ar::filter($usersToSendEmail, function($user) {
    return !empty($user->getEmail());
});
~~~

## Ar::reject()

~~~
function reject(array $array, callable $callback)
~~~

~~~
$callback = function(mixed $item) : bool {}
~~~

Opposing to Ar::filter(), this drops element by with returned true and stores with returned false.

~~~
$usersToSendEmail = $usersModel->getUsersToSendEmail();
$usersWithEmails = Ar::reject($usersToSendEmail, function($user) {
    return empty($user->getEmail());
});
~~~

## Ar::map()

~~~
function map(array $array, callable $callback)
~~~

~~~
$callback = function(mixed $item) : mixed {}
~~~

Maps one array to another using provided function on per-element basis.

~~~
$usersToSendEmail = $usersModel->getUsersToSendEmail();
$emails = Ar::map($usersToSendEmail, function($user) {
    return $user->getEmail();
});
// $emails now holds list of emails
~~~

## Ar::reduce()

~~~
function reduce(array $array, callable $callback, mixed $initialValue)
~~~

~~~
$callback = function(mixed $item, mixed $currentValue) : mixed {}
~~~

Reduces array to scalar value of any type.

Third parameter is initial scalar value, null by default.

~~~
$usersToCountAverageAge = $usersModel->getAllUsers();
$totalAge = Ar::reduce($usersToCountAverageAge, function($user, $currentAge) {
    return $currentAge + $user->getAge();
}, 0);
$averageAge = $totalAge / count($usersToCountAverageAge);
~~~