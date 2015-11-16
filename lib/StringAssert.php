<?php

/**
 * This file is part of assert.
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
                'Failed assertion that %s is a valid IP address', $value
            );
        });
    }

    public function isUrl($flags = 0)
    {
        return $this->doCheck(function ($value) use ($flags) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_URL, $flags),
                'Failed assertion that %s is a valid URL', $value
            );
        });
    }

    public function isEmail()
    {
        return $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_EMAIL),
                'Failed assertion that %s is a valid email address', $value
            );
        });
    }

    public function isMac()
    {
        return $this->doCheck(function ($value) {
            $this->throwExceptionIfFalse(
                filter_var($value, FILTER_VALIDATE_MAC),
                'Failed assertion that %s is a valid MAC address', $value
            );
        });
    }
}