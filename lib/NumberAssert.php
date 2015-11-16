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

class NumberAssert extends Assert
{
    /**
     * @param float $other
     * @param float $delta
     *
     * @return $this
     */
    public function equal($other, $delta = .0)
    {
        $this->isNumeric();

        if (0 === $delta) {
            return parent::equal($other);
        }

        return $this->doCheck(function ($value) use ($other, $delta) {
            $this->throwExceptionIfFalse(
                $this->isBetween($value - $other, -$delta, $delta),
                'Value %s is not equal to %s (±%s)', $value, $other, $delta
            );
        });
    }

    /**
     * @return $this
     */
    public function prime()
    {
        $this->isInteger();

        return $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(
                $this->doCheckPrime($value),
                'Value %s is not prime', $value
            );
        });
    }

    /**
     * @param int $value
     *
     * @return bool
     */
    private function doCheckPrime($value)
    {
        if (2 > $value) {
            return false;
        }

        if (2 == $value) {
            return true;
        }

        for ($i = 2; $i*$i <= $value; ++$i) {
            if (0 === $value % $i) {
                return false;
            }
        }

        return true;
    }
}
