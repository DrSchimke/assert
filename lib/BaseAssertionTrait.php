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
            if (!$value instanceof $className) {
                $this->throwException('Failed assertion that %s is an instance of %s', $value, $className);
            }
        });

        return $this;
    }

    public function isTraversable()
    {
        $this->doCheck(function ($value) {
            if (!is_array($value) && !$value instanceof \Traversable) {
                $this->throwException('Failed assertion that %s is traversable', $value);
            }
        });

        return $this;
    }
}
