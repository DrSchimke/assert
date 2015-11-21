# Extensible assertion library

[![Build Status](https://secure.travis-ci.org/DrSchimke/assert.png)](http://travis-ci.org/DrSchimke/assert)
[![Build Status](https://styleci.io/repos/36877074/shield)](https://styleci.io/repos/36877074)


PHP library heavily inspired by [beberlei/assert](https://github.com/beberlei/assert).

The purpose is a lightweight php library mainly for validating method parameters. The library's API is fluent [DSL](https://en.wikipedia.org/wiki/Domain-specific_language) like.

## Installation

Using [composer](https://getcomposer.org/download/):

```
composer require sci/assert dev-master
```

## Motivation

Just as an example, php is not able to typehint array-ish arguments, i.e. array or \Traversable:

```php
function foobar($values)
{
    foreach ($values as $value) {
        // ...
    }
}

$a = array(1, 2, 3);
$b = new \ArrayIterator($a);
$c = 'not that iterable';

foobar($a); // fine
foobar($b); // fine, too
foobar($c); // Invalid argument supplied for foreach()
```

Ignoring this and relying on @param-Annotations (`@param int[]` or `@param array|\Traversable`) is quite bad.

Having an explicit guard is verbose and needs a separate unit test to achieve code coverage:

```php
function foobar($values)
{
    if (!is_array($values) && !$values instanceof \Traversable) {
        throw new \InvalidArgumentException(/* ... */);
    }

    // ...
}
```

The solution may be this:

```php
use Sci\Assert\Assert;

function foobar($values)
{
    Assert::that($values)->isTraversable();

    // ...
}
```

## Examples

```php
use Sci\Assert\Assert;

// be it a string, matching a regular expression
Assert::that($value)->isString()->machesRegExp('/[A-Z][a-z+]/');

// be it a collection of strings, matching a regular expression
Assert::that($values)->all()->isString()->machesRegExp('/[A-Z][a-z+]/');

// be it a \DateTime and in year 2015 ('2015-01-01' <= $date < '2016-01-01')
Assert::that($date)
    ->isInstanceOf('\DateTime')
    ->greaterThanOrEqual(new \DateTime('2015-01-01'))
    ->lessThan(new \DateTime('2016-01-01'));

// ... or, in a different way:
Assert::that($date)
  ->isInstanceOf('\DateTime')
  ->between(new \DateTime('2015-01-01 00:00:00'), new \DateTime('2015-12-31 23:59:59'));

// be it a collection of \DateTime objects, each beeing in future
Assert::that($dates)->all()->isInstanceOf('\DateTime')->greaterThan(new \DateTime('now'));

// be it null, or a collection ...
Assert::that($dates)->nullOr()->isInstanceOf('\DateTime');
```

## Extending the library

The Assert library can be extended by subclassing. An example can be found here: [`NumberAssert`](lib/NumberAssert.php), which adds two changes to the [`Assert`](lib/Assert.php) base-class. First the `Assert::equal()` base method is extendes by a delta/tolerance argument, when used with numeric values: [`NumberAssert::equal()`](lib/NumberAssert.php#L21). Second, a prime number assertion is added: [`NumberAssert::prime()`](lib/NumberAssert.php#L40).

```php
use Sci\Assert\NumberAssert;

NumberAssert::that(3.1415)->equal(M_PI, .001);
NumberAssert::that(997)->prime();
```

or, for a better readability:

```php
use Sci\Assert\NumberAssert as Assert;

Assert::that(3.1415)->equal(M_PI, .001);
Assert::that(997)->prime();
```

## Complete assertion list

```php
use Sci\Assert\Assert;

// base assertions
Assert::that($value)->isString();
Assert::that($value)->isInteger();
Assert::that($value)->isNumeric();
Assert::that($value)->isScalar();
Assert::that($value)->isResource();
Assert::that($value)->isTrue();
Assert::that($value)->isTraversable();
Assert::that($value)->isInstanceOf('\DateTime');

// comparison assertions
Assert::that($value)->equal($valueRepeated);
Assert::that($value)->strictEqual($valueRepeated);

Assert::that($value)->lessThan(10);        // Assert::that($value)->lt(10);
Assert::that($value)->lessThanOrEqual(10); // Assert::that($value)->lte(10);

Assert::that($value)->greaterThan(10);        // Assert::that($value)->gt(10);
Assert::that($value)->greaterThanOrEqual(10); // Assert::that($value)->gte(10);

Assert::that($value)->between(10, 20); // same as Assert::that($value)->gte(10)->lte(20);
Assert::that($value)->between('aaaa', 'bbbbb');

// string assertions
Assert::that($value)->hasMinLength(8);
Assert::that($value)->matches('/^[A-Z][a-z]+$/');

// meta assertions
Assert::that($value)->all()->isString();
Assert::that($value)->nullOr()->isString();
```

```php
use Sci\Assert\StringAssert;

StringAssert::that($value)->isIpAddress();
StringAssert::that($value)->isIpAddress(FILTER_FLAG_IPV4);

StringAssert::that($value)->isUrl(FILTER_FLAG_QUERY_REQUIRED | FILTER_FLAG_PATH_REQUIRED);
StringAssert::that($value)->isEmail();
StringAssert::that($value)->isMac();
```

```php
use Sci\Assert\FileSystemAssert;

FileSystemAssert::that($filename)->exists();
FileSystemAssert::that($filename)->isFile();
FileSystemAssert::that($filename)->isDir();
FileSystemAssert::that($filename)->isLink();
```

## Differences

While beberlei's fluent API is function-based (```\Assert\that()```), the API of sci/assert uses a static method (```Assert::that()```). 
```php
\Assert\that(1)->integer()->min(-10)->max(10);
```

```php
use Sci\Assert\Assert;

Assert::that(1)->isInteger()->greaterThanOrEqual(-10)->lessThanOrEqual(10);
Assert::that(1)->isInteger()->gte(-10)->lte(10);
```

Although looking like an unimportant detail, the later solution is easier to extend by subclassing. See [here](#extending-the-library).

## License

All contents of this package are licensed under the [MIT license](LICENSE).
