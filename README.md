# Extensible assertion library

[![Build Status](https://secure.travis-ci.org/DrSchimke/assert.png)](http://travis-ci.org/DrSchimke/assert)

PHP library heavily inspired by [beberlei/assert](https://github.com/beberlei/assert).

The purpose is a light-weight php library mainly for validating method parameters.

## Installation

## Motivation

Just as an example, php is not able to typehint array-ish arguments, i.e. array or \Traversable:

```php
<?php
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
<?php
public function foobar($values)
{
    if (!is_array($values) && !$values instanceof \Traversable) {
        throw new \InvalidArgumentException(/* ... */);
    }

    // ...
}
```

The solumtion may be this:

```php
<?php
use Schimke\Assert\Assert;

public function foobar($values)
{
    Assert::that($values)->isTraversable();

    // ...
}
```

## Examples


## Differences

\Assert\that(1);
