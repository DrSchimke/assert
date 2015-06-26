# Extensible assertion library

[![Build Status](https://secure.travis-ci.org/DrSchimke/assert.png)](http://travis-ci.org/DrSchimke/assert)

PHP library heavily inspired by [beberlei/assert](https://github.com/beberlei/assert).

The purpose is a lightweight php library mainly for validating method parameters. The library's API is fluent DSL like.

## Installation

## Motivation

Just as an example, php is not able to typehint array-ish arguments, i.e. array or \Traversable:

```php
public function foobar($values)
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

Ignoring this and relying on @param-Annotations (```@param int[]``` or ```@param array|\Traversable```) is quite bad.

Having an explicit guard is verbose and needs a separate unit test to achieve code coverage:

```php
public function foobar($values)
{
    if (!is_array($values) && !$values instanceof \Traversable) {
        throw new \InvalidArgumentException(/* ... */);
    }

    // ...
}
```

The solution may be this:

```php
use Schimke\Assert\Assert;

public function foobar($values)
{
    Assert::that($values)->isTraversable();

    // ...
}
```

## Examples

```php
use Schimke\Assert\Assert;

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


## Differences

While beberlei's fluent API is based function-based (```\Assert\that()```), the API of sci/assert uses a static method (```Assert::that()```). Although looking like an unimportant detail, the later solution is easier to extend by subclassing.

```php
\Assert\that(1)->integer()->min(-10)->max(10);
```

```php
use Schimke\Assert\Assert;

Assert::that(1)->isInteger()->greaterThanOrEual(-10)->lessThanOrEqual(10);
Assert::that(1)->isInteger()->gte(-10)->lte(10);
```
