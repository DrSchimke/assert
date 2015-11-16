<?php

/**
 * This file is part of the sci/assert package.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Tests\Assert;

use Sci\Assert\Assert;

class StringAssertionTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function isString()
    {
        $foo = Assert::that('äöüÄÖÜß')->isString();

        $this->assertInstanceOf(Assert::class, $foo);
    }

    public function isStringFailsProvider()
    {
        return [
            [null],
            [1],
            [new \stdClass()],
            [STDIN],
        ];
    }

    /**
     * @test
     * @dataProvider isStringFailsProvider
     * @expectedException \InvalidArgumentException
     */
    public function isStringFails($noString)
    {
        Assert::that($noString)->isString();
    }

    /**
     * @test
     */
    public function minLength()
    {
        $string = str_repeat('a', 200);

        Assert::that($string)->hasMinLength(1)->hasMinLength(10)->hasMinLength(200);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function minLengthFails()
    {
        $string = str_repeat('a', 200);

        Assert::that($string)->hasMinLength(201);
    }
}
