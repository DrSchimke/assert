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

trait ComparisonAssertionTrait
{
    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function equal($other)
    {
        $this->doCheck(function ($value) use ($other) {
            $this->throwExceptionIfFalse(
                $value == $other,
                'Failed assertion that %s is same as %s', $value, $other
            );
        });

        return $this;
    }

    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function strictEqual($other)
    {
        $this->doCheck(function ($value) use ($other) {
            $this->throwExceptionIfFalse(
                $value === $other,
                'Failed assertion that %s is same as %s', $value, $other
            );
        });

        return $this;
    }

    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function lessThan($other)
    {
        $this->doCheck(function ($value) use ($other) {
            $this->throwExceptionIfFalse(
                $value < $other,
                'Failed assertion that %s is less than %s', $value, $other
            );
        });

        return $this;
    }

    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function greaterThan($other)
    {
        $this->doCheck(function ($value) use ($other) {
            $this->throwExceptionIfFalse(
                $value > $other,
                'Failed assertion that %s is greater than %s', $value, $other
            );
        });

        return $this;
    }

    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function lessThanOrEqual($other)
    {
        $this->doCheck(function ($value) use ($other) {
            $this->throwExceptionIfFalse(
                $value <= $other,
                'Failed assertion that %s is less than %s', $value, $other
            );
        });

        return $this;
    }

    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function greaterThanOrEqual($other)
    {
        $this->doCheck(function ($value) use ($other) {
            $this->throwExceptionIfFalse(
                $value >= $other,
                'Failed assertion that %s is greater than %s', $value, $other
            );
        });

        return $this;
    }

    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function lt($other)
    {
        return $this->lessThan($other);
    }

    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function lte($other)
    {
        return $this->lessThanOrEqual($other);
    }

    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function gt($other)
    {
        return $this->greaterThan($other);
    }

    /**
     * @param mixed $other
     *
     * @return $this
     */
    public function gte($other)
    {
        return $this->greaterThanOrEqual($other);
    }

    /**
     * @param mixed $min
     * @param mixed $max
     *
     * @return $this
     */
    public function between($min, $max)
    {
        $this->doCheck(function ($value) use ($min, $max) {
            $this->throwExceptionIfFalse(
                $min <= $value && $value <= $max,
                'Failed assertion that %s is between %s and %s', $value, $min, $max
            );
        });

        return $this;
    }
}
