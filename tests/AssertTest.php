<?php

namespace Sci\Tests\Assert;

use Sci\Assert\Assert;

class AssertTest extends \PHPUnit_Framework_TestCase
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
            [null, null]
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
        Assert::that($value1)->equal($value2);
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
            [null, 'one']
        ];
    }

    /**
     * @test
     * @expectedException \Exception
     * @dataProvider equalFailsProvider
     *
     * @param mixed $value1
     * @param mixed $value2
     */
    public function equalFails($value1, $value2)
    {
        Assert::that($value1)->equal($value2);
    }

    public function betweenProvider()
    {
        return [
            [2, 1, 3],
            [0, -10, 10],
            ['foo', 'bar', 'foobar'],
            ['foobar', 'foo', 'foobaz'],
            [1, 1, 1],
            [new \DateTime('2015-01-01'), new \DateTime('2014-12-31 23:59:59'), new \DateTime('2015-01-01 00:00:01')]
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
    }

    public function betweenFailsProvider()
    {
        return [
            [1, 2, 3],
            ['foo', 'bar', 'baz'],
            [new \DateTime('2015-01-02'), new \DateTime('2014-12-31'), new \DateTime('2015-01-01')]
        ];
    }

    /**
     * @test
     * @expectedException \Exception
     * @dataProvider betweenFailsProvider
     *
     * @param mixed $value
     * @param mixed $min
     * @param mixed $max
     */
    public function betweenFails($value, $min, $max)
    {
        Assert::that($value)->between($min, $max);
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
        Assert::that($values)->all()->between($min, $max);
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
     * @expectedException \Exception
     * @dataProvider allBetweenFailsProvider
     *
     * @param array $values
     * @param mixed $min
     * @param mixed $max
     */
    public function allBetweenFails($values, $min, $max)
    {
        Assert::that($values)->all()->between($min, $max);
    }
}
