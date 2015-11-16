<?php

/**
 * This file is part of sci/assert.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Tests\Assert;

use Sci\Assert\StringAssert as Assert;

class StringAssertTest extends \PHPUnit_Framework_TestCase
{
    public function isIpv4Provider()
    {
        return [
            ['8.8.8.8'],
            ['192.168.1.2'],
            ['255.1.1.1'],
        ];
    }

    /**
     * @test
     * @dataProvider isIpv4Provider
     */
    public function isIpAddress($ip)
    {
        Assert::that($ip)->isIpAddress();
    }
}