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
     * 当返回的是数组的时候将属性值覆盖
     *
     * @param [type] $array
     * @return void
     */
    public function generateNewArray($func, $origins, $expecteds, $params)
    {
        $this->instance->array($origins);

        $this->assertInstanceOf(ArrayOoe::class, $this->instance);

        $this->instance->{$func}(...$params);

        $this->assertInstanceOf(ArrayOoe::class, $this->instance);

        $actual = $this->instance->get();

        $this->assertEquals($expecteds, $actual);
    }

    /**
     * @test
     */
    public function testChangeKeyCase()
    {
        $origins = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4];
        $expecteds = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

        $this->generateNewArray(__FUNCTION__, $origins, $expecteds);
    }

    /**
     * @test
     */
    public function testChunk()
    {
        $origins = [1, 2, 3, 4];
        $expecteds = [
            [1, 2],
            [3, 4],
        ];

        $this->generateNewArray(__FUNCTION__, $origins, $expecteds, [2]);
    }

    /**
     * @test
     */
    public function column()
    {
        $origins = [
            ['a' => 11, 'b' => 12, 'c' => 13],
            ['a' => 21, 'b' => 22, 'c' => 23],
            ['a' => 31, 'b' => 32, 'c' => 33],
        ];

        $expecteds = [11, 21, 31];

        $this->generateNewArray(__FUNCTION__, $origins, $expecteds, ['a']);
    }

}
