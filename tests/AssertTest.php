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

class AssertTest extends \PHPUnit_Framework_TestCase
{
    public function allLessThan()
    {
        $foo = Assert::that([1, 2, 3, 4, 5, 6])->all()->lessThan(10);

        $this->assertInstanceOf(Assert::class, $foo);
    }

    /**
     * @test
     */
    public function nullOrEquals()
    {
        $foo = Assert::that(null)->nullOr()->equal(1);
        $bar = Assert::that(1)->nullOr()->equal(1);

        $this->assertInstanceOf(Assert::class, $foo);
        $this->assertInstanceOf(Assert::class, $bar);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function nullOrEqualsFails()
    {
        Assert::that(2)->nullOr()->equal(1);
    }
}
