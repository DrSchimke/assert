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

use Sci\Assert\NumberAssert;

class NumberAssertTest extends \PHPUnit_Framework_TestCase
{
    public function equalProvider()
    {
        return [
            [1, 2, 1, true],
            [1, 2, 0, false],
            [1, 2, 0.9, false],
        ];
    }

    /**
     * @param float $value
     * @param float $other
     * @param float $delta
     * @param bool  $ok
     *
     * @test
     * @dataProvider equalProvider
     */
    public function equal($value, $other, $delta, $ok)
    {
        if (!$ok) {
            $this->setExpectedException('InvalidArgumentException');
        }

        $foo = NumberAssert::that($value)->equal($other, $delta);

        $this->assertInstanceOf(NumberAssert::CLASS_NAME, $foo);
    }

    public function primeProvider()
    {
        return [
            [1, false],
            [2, true],
            [3, true],
            [4, false],
            [5, true],
            [6, false],
            [7, true],
            [8, false],
            [9, false],
            [997, true],
        ];
    }

    /**
     * @param int  $value
     * @param bool $ok
     *
     * @test
     * @dataProvider primeProvider
     */
    public function prime($value, $ok)
    {
        if (!$ok) {
            $this->setExpectedException('InvalidArgumentException');
        }

        $foo = NumberAssert::that($value)->prime();

        $this->assertInstanceOf(NumberAssert::CLASS_NAME, $foo);
    }
}
