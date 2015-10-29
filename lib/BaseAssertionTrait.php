<?php

/**
 * This file is part of sci/assert.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Assert;

trait BaseAssertionTrait
{
    /**
     * @param string $className
     *
     * @return Assert
     */
    public function isInstanceOf($className)
    {
        $this->doCheck(function ($value) use ($className) {
            $this->throwExceptionIfFalse(
                $value instanceof $className,
                'Failed assertion that %s is an instance of %s', $value, $className
            );
        });

        return $this;
    }

    public function isTraversable()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(
                is_array($value) || $value instanceof \Traversable,
                'Failed assertion that %s is traversable', $value
            );
        });

        return $this;
    }

    public function isInteger()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(is_int($value), 'Failed assertion that %s is integer', $value);
        });

        return $this;
    }

    public function isFloat()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(is_float($value), 'Failed assertion that %s is float', $value);
        });

        return $this;
    }

    public function isNumeric()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(is_numeric($value), 'Failed assertion that %s is numeric', $value);
        });

        return $this;
    }

    public function isScalar()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(is_scalar($value), 'Failed assertion that %s is scalar', $value);
        });

        return $this;
    }

    public function isResource()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(is_resource($value), 'Failed assertion that %s is a resource', $value);
        });

        return $this;
    }

    public function isTrue()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(true === $value, 'Failed assertion that %s is true', $value);
        });

        return $this;
    }
}
