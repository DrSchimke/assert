<?php

namespace Sci\Assert;

class Assert
{
    /** @var mixed */
    private $value;

    /** @var bool */
    private $plural;

    /** @var bool */
    private $alwaysValid;

    /**
     * @param mixed $value
     */
    final private function __construct($value)
    {
        $this->value = $value;

        $this->plural      = false;
        $this->alwaysValid = false;
    }

    /**
     * @param mixed $value
     *
     * @return Assert
     */
    final public static function that($value)
    {
        return new self($value);
    }

    public function all()
    {
        $this->isTraversable();

        $this->plural = true;

        return $this;
    }

    public function nullOr()
    {
        if ($this->value === null) {
            $this->alwaysValid = true;
        }

        return $this;
    }

    /**
     * @param string $className
     *
     * @return Assert
     */
    public function isInstanceOf($className)
    {
        $this->doCheck(function ($value) use ($className) {
            if (!$value instanceof $className) {
                throw $this->createException('Failed assertion that %s is an instance of %s', $value, $className);
            }
        });

        return $this;

    }

    public function isString()
    {
        $this->doCheck(function ($value) {
            if (!is_string($value)) {
                throw $this->createException('Failed assertion that %s is a string', $value);
            }
        });

        return $this;
    }

    public function isTraversable()
    {
        $this->doCheck(function ($value) {
            if (!is_array($value) && !$value instanceof \Traversable) {
                throw $this->createException('Failed assertion that %s is traversable', $value);
            }
        });

        return $this;
    }

    public function equal($other)
    {
        $this->doCheck(function ($value) use ($other) {
            if ($value != $other) {
                throw $this->createException('Failed assertion that %s is same as %s', $value, $other);
            }
        });

        return $this;
    }

    public function strictEqual($other)
    {
        $this->doCheck(function ($value) use ($other) {
            if ($value !== $other) {
                throw $this->createException('Failed assertion that %s is same as %s', $value, $other);
            }
        });

        return $this;
    }

    public function lessThan($other)
    {
        $this->doCheck(function ($value) use ($other) {
            if ($value >= $other) {
                throw $this->createException('Failed assertion that %s is less than %s', $value, $other);
            }
        });

        return $this;
    }

    public function greaterThan($other)
    {
        $this->doCheck(function ($value) use ($other) {
            if ($value <= $other) {
                throw $this->createException('Failed assertion that %s is greater than %s', $value, $other);
            }
        });

        return $this;
    }

    public function lessThanOrEqual($other)
    {
        $this->doCheck(function ($value) use ($other) {
            if ($value > $other) {
                throw $this->createException('Failed assertion that %s is less than %s', $value, $other);
            }
        });

        return $this;
    }

    public function greaterThanOrEqual($other)
    {
        $this->doCheck(function ($value) use ($other) {
            if ($value < $other) {
                throw $this->createException('Failed assertion that %s is greater than %s', $value, $other);
            }
        });

        return $this;
    }

    public function lt($other)
    {
        return $this->lessThan($other);
    }

    public function lte($other)
    {
        return $this->lessThanOrEqual($other);
    }

    public function gt($other)
    {
        return $this->greaterThan($other);
    }

    public function gte($other)
    {
        return $this->greaterThanOrEqual($other);
    }

    public function between($min, $max)
    {
        $this->doCheck(function ($value) use ($min, $max) {
            if ($value < $min || $value > $max) {
                throw $this->createException('Failed assertion that %s is between %s and %s', $value, $min, $max);
            }
        });

        return $this;
    }

    public function hasMinLength($minLength)
    {
        $this->isString();

        $this->doCheck(function ($value) use ($minLength) {
            if (mb_strlen($value) < $minLength) {
                throw $this->createException('Failed assertion that %s has at least %s characters', $value, $minLength);
            }
        });

        return $this;
    }

    protected function doCheck(callable $check)
    {
        if (!$this->alwaysValid) {
            $values = $this->plural ? $this->value : [$this->value];

            foreach ($values as $value) {
                call_user_func($check, $value);
            }
        }

        return $this;
    }

    protected function createException()
    {
        $args = func_get_args();
        $args = array_map([$this, 'stringify'], $args);

        $message = call_user_func_array('sprintf', $args);

        return new InvalidArgumentException($message);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    private function stringify($value)
    {
        if (is_bool($value)) {
            return $value ? '<TRUE>' : '<FALSE>';
        }

        if (is_scalar($value)) {
            $val = (string)$value;

            if (strlen($val) > 100) {
                $val = substr($val, 0, 97) . '...';
            }

            return $val;
        }

        if (is_array($value)) {
            return '<ARRAY>';
        }

        if (is_object($value)) {
            return sprintf('%s [%s]', get_class($value), spl_object_hash($value));
        }

        if (is_resource($value)) {
            return '<RESOURCE>';
        }

        if ($value === NULL) {
            return '<NULL>';
        }

        return 'unknown';
    }
}
