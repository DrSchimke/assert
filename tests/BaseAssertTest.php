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

class BaseAssertTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function isInstance()
    {
        $foo = Assert::that(new \DateTime())->isInstanceOf('\\DateTime');

        $this->assertInstanceOf(Assert::CLASS_NAME, $foo);
    }

    public function isInstanceOfFailsProvider()
    {
        return [
            [new \DateTime(), '\\Iterator'],
            [null, '\\DateTime'],
            ['2014-01-01', '\\DateTime'],
        ];
    }

    /**
     * @test
     * @dataProvider isInstanceOfFailsProvider
     * @expectedException \InvalidArgumentException
     *
     * @param mixed  $value
     * @param string $className
     */
    public function isInstanceOfFails($value, $className)
    {
        Assert::that($value)->isInstanceOf($className);
    }

    public function isTraversableProvider()
    {
        return [
           [[]],
           [[1, 2]],
           [new \ArrayIterator()],
        ];
    }

    /**
     * @test
     * @dataProvider isTraversableProvider
     */
    public function isTraversable($value)
    {
        $foo = Assert::that($value)->isTraversable();

        $this->assertInstanceOf(Assert::CLASS_NAME, $foo);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function isTraversableFails()
    {
        Assert::that(0)->isTraversable();

        $this->assertTrue(true);
    }
}
