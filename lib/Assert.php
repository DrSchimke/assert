<?php

namespace Sci\Assert;

class Assert
{
    private $value;

    private $plural;

    private function __construct($value, $all = false)
    {
        $this->value = $value;
        $this->plural = $all;
    }

    public static function that($value)
    {
        return new self($value);
    }

    public static function thatAll($values)
    {
        return new self($values, true);
    }

    public function isInstanceOf($className)
    {
        return $this;
    }

    public function isArrayIsh()
    {
        if (!is_array($this->value) && !$this->value instanceof \Traversable) {
            throw $this->createException('Failed assertion that %s is arrayish');
        }

        return $this;
    }

    public function equal($other)
    {
        if ($this->value != $other) {
            throw $this->createException('Failed assertion that %s is same as %s', $this->value, $other);
        }

        return $this;
    }

    public function same($other)
    {
        if ($this->value !== $other) {
            throw $this->createException('Failed assertion that %s is same as %s', $this->value, $other);
        }

        return $this;
    }

    public function between($min, $max)
    {
        $values = $this->plural ? $this->value : [$this->value];

        foreach ($values as $value) {
            if ($value < $min || $value > $max) {
                throw $this->createException('Failed assertion that %s is between %s and %s', $this->value, $min, $max);
            }
        }

        return $this;
    }

    protected function createException()
    {
        $args = func_get_args();
        $args = array_map([$this, 'stringify'], $args);

        $message = call_user_func_array('sprintf', $args);

        return new Exception($message);
    }

    public function all()
    {
        $this->isArrayIsh();

        $this->plural = true;

        return $this;
    }

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
            return get_class($value);
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
