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

trait StringAssertionTrait
{
    /**
     * @return $this
     */
    public function isString()
    {
        $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(
                is_string($value),
                'Failed assertion that %s is a string', $value
            );
        });

        return $this;
    }

    /**
     * @param int $minLength
     *
     * @return $this
     */
    public function hasMinLength($minLength)
    {
        $this->isString();

        $this->doCheck(function ($value) use ($minLength) {
            $this->throwExceptionIfFalse(
                mb_strlen($value) >= $minLength,
                'Failed assertion that %s has at least %s characters', $value, $minLength
            );
        });

        return $this;
    }
}
