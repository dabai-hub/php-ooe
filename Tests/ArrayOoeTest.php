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
    public function testChangeKeyCase()
    {
        $origins = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4];
        $expecteds = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

        $this->checkAttribute('changeKeyCase', $origins, $expecteds, CASE_LOWER);
    }

    public function testChunk()
    {
        $origins = [1, 2, 3, 4];
        $expecteds = [
            [1, 2],
            [3, 4],
        ];

        $this->checkAttribute('chunk', $origins, $expecteds, 2);
    }

    public function testColumn()
    {
        $origins = [
            ['a' => 11, 'b' => 12, 'c' => 13],
            ['a' => 21, 'b' => 22, 'c' => 23],
            ['a' => 31, 'b' => 32, 'c' => 33],
        ];
        $expecteds = [11, 21, 31];

        $this->checkAttribute('column', $origins, $expecteds, 'a');
    }

    private function checkAttribute($func, $origins, $expecteds, ...$params)
    {
        $instance = new ArrayOoe($origins);

        $this->assertInstanceOf(ArrayOoe::class, $instance);

        $result = $instance->{$func}(...$params);

        $this->assertInstanceOf(ArrayOoe::class, $result);

        $actual = $result->get();

        $this->assertEquals($expecteds, $actual);
    }

}
