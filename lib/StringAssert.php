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

class StringAssert extends Assert
{
    const CLASS_NAME = __CLASS__;

    /**
     * @param int $flags
     *
     * @return $this
     */
    public function isIpAddress($flags = 0)
    {
        $this->isString();

        return $this->doCheck(function ($value) use ($flags) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_IP, $flags),
                '"%s" is not a valid IP address.', $value
            );
        });
    }

    /**
     * @param int $flags
     *
     * @return $this
     */
    public function isUrl($flags = 0)
    {
        $this->isString();

        return $this->doCheck(function ($value) use ($flags) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_URL, $flags),
                '"%s" is not a valid URL.', $value
            );
        });
    }

    public function isEmail()
    {
        $this->isString();

        return $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_EMAIL),
                '"%s" is not a valid email address.', $value
            );
        });
    }

    public function isMac()
    {
        $this->isString();

        return $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_MAC),
                '"%s" is not a valid MAC address.', $value
            );
        });
    }

    /**
     * @param string $other
     * @param bool   $trim
     *
     * @return $this
     */
    public function equal($other, $trim = false)
    {
        $this->isString();

        if (false === $trim) {
            return parent::equal($other);
        }

        return $this->doCheck(function ($value) use ($other) {
            $this->throwExceptionIfFalse(
                trim($value) === trim($other),
                'Value %s is not equal to %s', $value, $other
            );
        });
    }
}
