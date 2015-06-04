<?php

namespace Sci\Tests\Assert;

use Sci\Assert\Assert;

class AssertTest extends \PHPUnit_Framework_TestCase
{
    public function testEqual()
    {
//        Assert::that([1, 2])->equal([1, 2]);
    }

    public function testBetween()
    {
//        Assert::thatAll([5, 6, 7, 10, 9])->between(1, 10);
        Assert::that([5, 6, 7, 10, 9])->all()->between(1, 10);
        Assert::that(null)->nullOr()->between(1, 10);
    }

}
