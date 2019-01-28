<?php declare (strict_types = 1);

/*
 * This file is part of the Ooe package.
 *
 * (c) Zixing He <studyforzx@gmail.com>
 *
 */

namespace Test\ArrayOoe;

use Hezalex\Ooe\ArrayOoe;
use PHPUnit\Framework\TestCase;

class ChangeKeyCaseTest extends TestCase
{

    private $instance;

    /**
     * @test
     */
    public function testGetInstance()
    {
        $instance = new ArrayOoe();

        $this->assertTrue($instance instanceof ArrayOoe);

        $this->instance = $instance;
    }

    /**
     * @test
     */
    public function testChangeKeyCase()
    {
        $origins = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4];
        $expecteds = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

        $ins = new ArrayOoe($origins);

        $actual = $ins->changeKeyCase()->get();

        $this->assertEquals(expecteds, $actual);
    }

    public function testChunk()
    {
        $origins = [1, 2, 3, 4];
        $expecteds = [
            [1, 2],
            [3, 4],
        ];

        $ins = new ArrayOoe($origins);

        $actual = $ins->chunk()->get();

        $this->assertEquals(expecteds, $actual);
    }
}
