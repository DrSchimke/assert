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

class ComparisonAssertTest extends \PHPUnit_Framework_TestCase
{
    public function equalProvider()
    {
        return [
            [1, 1],
            [1., 1.],
            [1, 1.],
            [1, '1'],
            ['foobar', 'foobar'],
            [null, null],
            [new \DateTime('2015-01-01'), new \DateTime('2015-01-01')],
            [new \DateTime('2015-01-01 05:00:00+0200'), new \DateTime('2015-01-01 04:00:00+0100')],
            [[], []],
            [[1, 2, 3], [1, 2, 3]],
            [['one' => 1, 'two' => 2], ['two' => 2, 'one' => 1]],
            [STDIN, STDIN],
            [true, true],
            [false, false],
            [null, null],
        ];
    }

    /**
     * @test
     * @dataProvider equalProvider
     *
     * @param mixed $value1
     * @param mixed $value2
     */
    public function equal($value1, $value2)
    {
        $foo = Assert::that($value1)->equal($value2);

        $this->assertInstanceOf(Assert::class, $foo);
    }

    public function equalFailsProvider()
    {
        return [
            [1, 2],
            [1., 2.],
            [1, '2'],
            ['foobar', 'baz'],
            [new \DateTime('2015-01-01 05:00:00+0200'), new \DateTime('2015-01-01 04:00:00+0130')],
            [[1, 2, 3], [1, 3, 2]],
            [STDIN, STDOUT],
            [STDIN, STDERR],
            [STDOUT, STDERR],
            [true, false],
            [null, 'one'],
        ];
    }

    /**
     * @test
     * @dataProvider equalFailsProvider
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $value1
     * @param mixed $value2
     */
    public function equalFails($value1, $value2)
    {
        Assert::that($value1)->equal($value2);

        $this->assertTrue(true);
    }

    public function betweenProvider()
    {
        return [
            [2, 1, 3],
            [0, -10, 10],
            ['foo', 'bar', 'foobar'],
            ['foobar', 'foo', 'foobaz'],
            [1, 1, 1],
            [new \DateTime('2015-01-01'), new \DateTime('2014-12-31 23:59:59'), new \DateTime('2015-01-01 00:00:01')],
        ];
    }

    /**
     * @test
     * @dataProvider betweenProvider
     *
     * @param mixed $value
     * @param mixed $min
     * @param mixed $max
     */
    public function between($value, $min, $max)
    {
        Assert::that($value)->between($min, $max);

        $this->assertTrue(true);
    }

    public function betweenFailsProvider()
    {
        return [
            [1, 2, 3],
            ['foo', 'bar', 'baz'],
            [new \DateTime('2015-01-02'), new \DateTime('2014-12-31'), new \DateTime('2015-01-01')],
        ];
    }

    /**
     * @test
     * @dataProvider betweenFailsProvider
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $value
     * @param mixed $min
     * @param mixed $max
     */
    public function betweenFails($value, $min, $max)
    {
        Assert::that($value)->between($min, $max);
    }

    /**
     * @test
     */
    public function isInstance()
    {
        $foo = Assert::that(new \DateTime())->isInstanceOf('\\DateTime');

        $this->assertInstanceOf(Assert::class, $foo);
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

        $this->assertInstanceOf(Assert::class, $foo);
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

    public function allBetweenProvider()
    {
        return [
            [[1, 2, 3, 4, 5, 6, 7, 8, 9], 1, 9],
            [['a', 'aa', 'ab', 'ac', 'azzzzzz'], 'a', 'b'],
        ];
    }

    /**
     * @test
     * @dataProvider allBetweenProvider
     *
     * @param array $values
     * @param mixed $min
     * @param mixed $max
     */
    public function allBetween($values, $min, $max)
    {
        $foo = Assert::that($values)->all()->between($min, $max);

        $this->assertInstanceOf(Assert::class, $foo);
    }

    public function allBetweenFailsProvider()
    {
        return [
            [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9], 1, 9],
            [[1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 1, 9],
            [[1, 2, 3, 4, 5, 6, 7, 8, 9], 9, 1],
            [['a', 'aa', 'ab', 'ac', 'azzzzzz', 'ba'], 'a', 'b'],
        ];
    }

    /**
     * @test
     * @dataProvider allBetweenFailsProvider
     * @expectedException \InvalidArgumentException
     *
     * @param array $values
     * @param mixed $min
     * @param mixed $max
     */
    public function allBetweenFails($values, $min, $max)
    {
        Assert::that($values)->all()->between($min, $max);
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

    public function orderProvider()
    {
        return [
            [1, 2],
            ['aaa', 'aaab'],
            ['aaa', 'aaaa'],
            [new \DateTime('today'), new \DateTime('tomorrow')],
        ];
    }

    public function semiOrderProvider()
    {
        return [
            [1, 2],
            [1, 1],
            ['aaa', 'aaab'],
            ['aaa', 'aaaa'],
            ['aaa', 'aaa'],
            [new \DateTime('today'), new \DateTime('tomorrow')],
            [new \DateTime('today 12:00:00'), new \DateTime('today 12:00:00')],
        ];
    }

    /**
     * @test
     * @dataProvider orderProvider
     *
     * @param $a
     * @param $b
     */
    public function lt($a, $b)
    {
        $foo = Assert::that($a)->lt($b);

        $this->assertInstanceOf(Assert::class, $foo);
    }

    /**
     * @test
     * @dataProvider orderProvider
     *
     * @param $a
     * @param $b
     */
    public function gt($a, $b)
    {
        $foo = Assert::that($b)->gt($a);

        $this->assertInstanceOf(Assert::class, $foo);
    }

    /**
     * @test
     * @dataProvider semiOrderProvider
     *
     * @param $a
     * @param $b
     */
    public function lte($a, $b)
    {
        $foo = Assert::that($a)->lte($b);

        $this->assertInstanceOf(Assert::class, $foo);
    }

    /**
     * @test
     * @dataProvider semiOrderProvider
     *
     * @param $a
     * @param $b
     */
    public function gte($a, $b)
    {
        $foo = Assert::that($b)->gte($a);

        $this->assertInstanceOf(Assert::class, $foo);
    }

    /**
     * @test
     * @dataProvider semiOrderProvider
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $a
     * @param mixed $b
     */
    public function ltFails($a, $b)
    {
        Assert::that($b)->lt($a);
    }

    /**
     * @test
     * @dataProvider semiOrderProvider
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $a
     * @param mixed $b
     */
    public function gtFails($a, $b)
    {
        Assert::that($a)->gt($b);
    }

    /**
     * @test
     * @dataProvider orderProvider
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $a
     * @param mixed $b
     */
    public function lteFails($a, $b)
    {
        Assert::that($b)->lte($a);
    }

    /**
     * @test
     * @dataProvider orderProvider
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $a
     * @param mixed $b
     */
    public function gteFails($a, $b)
    {
        Assert::that($a)->gte($b);
    }

    public function strictEqualsProvider()
    {
        $object = new \stdClass();

        return [
            [1, 1],
            [null, null],
            [$object, $object],
            [[1, 2], [1, 2]],
        ];
    }

    /**
     * @test
     * @dataProvider strictEqualsProvider
     *
     * @param $a
     * @param $b
     */
    public function strictEquals($a, $b)
    {
        $foo = Assert::that($a)->strictEqual($b);

        $this->assertInstanceOf(Assert::class, $foo);
    }

    public function strictEqualsFailsProvider()
    {
        return [
            [1, 2],
            [null, 2],
            [new \stdClass(), new \stdClass()],
            [[1, 2], [2, 1]],
        ];
    }

    /**
     * @test
     * @dataProvider strictEqualsFailsProvider
     * @expectedException \InvalidArgumentException
     *
     * @param $a
     * @param $b
     */
    public function strictEqualsFails($a, $b)
    {
        Assert::that($a)->strictEqual($b);
    }
}
