<?php

namespace Sci\Tests\Assert;

use Sci\Assert\Assert;

class AssertTest extends \PHPUnit_Framework_TestCase
{
    public function testEqual()
    {
        Assert::that([1, 2])->equal([1, 2]);
    }
}
