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
    public function isString()
    {
        $this->doCheck(function($value) {
            if (!is_string($value)) {
                $this->throwException('Failed assertion that %s is a string', $value);
            }
        });

        return $this;
    }

    public function hasMinLength($minLength)
    {
        $this->isString();

        $this->doCheck(function($value) use ($minLength) {
            if (mb_strlen($value) < $minLength) {
                $this->throwException('Failed assertion that %s has at least %s characters', $value, $minLength);
            }
        });

        return $this;
    }
}
