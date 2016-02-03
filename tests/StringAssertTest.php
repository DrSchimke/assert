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
    public function ipAddressProvider()
    {
        return [
            ['0.0.0.0', null, true],
            ['8.8.8.8', null, true],
            ['8.8.8.8', FILTER_FLAG_IPV4, true],
            ['8.8.8.8', FILTER_FLAG_IPV6, false],
            ['192.168.1.1', null, true],
            ['192.168.1.1', FILTER_FLAG_NO_PRIV_RANGE, false],
            ['255.255.255.255', null, true],
            ['256.255.255.255', null, false],
            ['::', null, true],
            ['::1', null, true],
            ['::1', FILTER_FLAG_IPV4, false],
            ['::1', FILTER_FLAG_IPV6, true],
            ['fe80::7433:9fff:fece:460e', FILTER_FLAG_IPV6, true],
            ['ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff', null, true],
            ['foo', null, false],
        ];
    }

    /**
     * @test
     * @dataProvider ipAddressProvider
     *
     * @param string $ipAddress
     * @param int    $flags
     * @param bool   $ok
     */
    public function isIpAddress($ipAddress, $flags, $ok)
    {
        if (!$ok) {
            $this->setExpectedException('\InvalidArgumentException');
        }

        $foo = Assert::that($ipAddress)->isIpAddress($flags);

        $this->assertInstanceOf(Assert::CLASS_NAME, $foo);
    }

    public function urlProvider()
    {
        return [
            ['foo://bar', null, true],
            ['foo://bar/baz', FILTER_FLAG_PATH_REQUIRED, true],
            ['foo://bar', FILTER_FLAG_PATH_REQUIRED, false],
            ['foo://bar?baz', FILTER_FLAG_PATH_REQUIRED, false],
            ['foo://bar?baz', FILTER_FLAG_QUERY_REQUIRED, true],
            ['foo://bar', FILTER_FLAG_QUERY_REQUIRED, false],
            ['foo://bar/baz', FILTER_FLAG_QUERY_REQUIRED, false],
            ['foo://bar/baz?fop', FILTER_FLAG_QUERY_REQUIRED | FILTER_FLAG_PATH_REQUIRED, true],
            ['foo://user:pass@bar:123/baz?fop#anchor', null, true],
        ];
    }

    /**
     * @test
     * @dataProvider urlProvider
     *
     * @param string $url
     * @param int    $flags
     * @param bool   $ok
     */
    public function isUrl($url, $flags, $ok)
    {
        if (!$ok) {
            $this->setExpectedException('\InvalidArgumentException');
        }

        $foo = Assert::that($url)->isUrl($flags);

        $this->assertInstanceOf(Assert::CLASS_NAME, $foo);
    }

    public function emailAddressProvider()
    {
        return [
            ['foo@bar.de', true],
            ['foo@bar.quite-long-tld', true],
            ['foo+fop@bar.de', true],
            ['foo_fop@bar.de', true],
            ['foo@1.2.3.4.de', true],
            ['foo@1.2.3.4.5.6.7.8.9.0.1.2.3.4.5.6.7.de', true],
            ['foo.1.2.3.4.5.6.7.8.9@bar.de', true],

            ['äöü@bar.de', false],
            ['foo@bar', false],
            ['@bar.de', false],
            ['foo@', false],
            ['foo@bar_baz.de', false],
        ];
    }

    /**
     * @test
     * @dataProvider emailAddressProvider
     *
     * @param string $emailAddress
     * @param bool   $ok
     */
    public function isEmail($emailAddress, $ok)
    {
        if (!$ok) {
            $this->setExpectedException('\InvalidArgumentException');
        }

        $foo = Assert::that($emailAddress)->isEmail();

        $this->assertInstanceOf(Assert::CLASS_NAME, $foo);
    }

    public function macAddressProvider()
    {
        return [
            ['52:ca:38:d0:32:83', true],
            ['de:ad:be:ef:00:00', true],
            ['DE:AD:BE:EF:00:00', true],

            ['de:ad:be:ef:00', false],
            ['gg:ad:be:ef:00:00', false],
        ];
    }

    /**
     * @test
     * @dataProvider macAddressProvider
     *
     * @param string $macAddress
     * @param bool   $ok
     */
    public function isMacAddress($macAddress, $ok)
    {
        if (!$ok) {
            $this->setExpectedException('\InvalidArgumentException');
        }

        $foo = Assert::that($macAddress)->isMac();

        $this->assertInstanceOf(Assert::CLASS_NAME, $foo);
    }

    /**
     * @test
     */
    public function equal()
    {
        Assert::that('foo')->equal('foo');
        Assert::that('foo')->equal('foo', true);
        Assert::that('foo')->equal(' foo ', true);
        Assert::that('foo ')->equal(' foo ', true);
        Assert::that(' foo')->equal(' foo ', true);

        $this->assertTrue(true);
    }
}
