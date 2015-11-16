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
    public function isIpAddress($flags = 0)
    {
        return $this->doCheck(function ($value) use ($flags) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_IP, $flags),
                '"%s" is not a valid IP address.', $value
            );
        });
    }

    public function isUrl($flags = 0)
    {
        return $this->doCheck(function ($value) use ($flags) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_URL, $flags),
                '"%s" is not a valid URL.', $value
            );
        });
    }

    public function isEmail()
    {
        return $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_EMAIL),
                '"%s" is not a valid email address.', $value
            );
        });
    }

    public function isMac()
    {
        return $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_MAC),
                '"%s" is not a valid MAC address.', $value
            );
        });
    }
}
