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

    public function testCombine()
    {
        $origins = ['a', 'b', 'c', 'd'];
        $param = [1, 2, 3, 4];
        $expecteds = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];

        $this->checkAttribute('combine', $origins, $expecteds, $param);
    }

    public function testCountValues()
    {
        $origins = [1, 1, 2, 2, 3, 4, 5, 5, 5];
        $expecteds = [
            1 => 2,
            2 => 2,
            3 => 1,
            4 => 1,
            5 => 3,
        ];

        $this->checkAttribute('countValues', $origins, $expecteds);
    }

    public function testDiffAssoc()
    {
        $origins = ['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red'];
        $param = ['a' => 'green', 'yellow', 'red'];
        $expecteds = ['b' => 'brown', 'c' => 'blue', 'red'];

        $this->checkAttribute('diffAssoc', $origins, $expecteds, $param);
    }

    public function testDiffKey()
    {
        $origins = ['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4];
        $param = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan' => 8];
        $expecteds = ['red' => 2, 'purple' => 4];

        $this->checkAttribute('diffKey', $origins, $expecteds, $param);
    }

    public function testDiffUassoc()
    {
        $origins = ['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red'];
        $param = ['a' => 'green', 'yellow', 'red'];
        $closure = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return ($a > $b) ? 1 : -1;
        };
        $expecteds = ['b' => 'brown', 'c' => 'blue', 'red'];

        $this->checkAttribute('diffUassoc', $origins, $expecteds, $param, $closure);
    }

    public function testDiffUkey()
    {
        $origins = ['blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4];
        $param = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan' => 8];
        $closure = function ($key1, $key2) {
            if ($key1 == $key2) {
                return 0;
            } elseif ($key1 > $key2) {
                return 1;
            } else {
                return -1;
            }
        };
        $expecteds = ['red' => 2, 'purple' => 4];

        $this->checkAttribute('diffUkey', $origins, $expecteds, $param, $closure);
    }

    public function testDiff()
    {
        $origins = ['a' => 'green', 'red', 'blue', 'red'];
        $param = ['b' => 'green', 'yellow', 'red'];
        $expecteds = [1 => 'blue'];

        $this->checkAttribute('diff', $origins, $expecteds, $param);
    }

    public function testFillKeys()
    {
        $origins = ['foo', 5, 10, 'bar'];
        $value = 'banana';
        $expecteds = [
            'foo' => 'banana',
            5 => 'banana',
            10 => 'banana',
            'bar' => 'banana',
        ];

        $this->checkAttribute('fillKeys', $origins, $expecteds, $value);
    }

    public function testFill()
    {
        $start = 5;
        $num = 6;
        $value = 'banana';
        $expecteds = [
            5 => 'banana',
            6 => 'banana',
            7 => 'banana',
            8 => 'banana',
            9 => 'banana',
            10 => 'banana',
        ];

        $this->checkAttribute('fill', [], $expecteds, $start, $num, $value);
    }

    public function testFilter()
    {
        $origins = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $closure = function ($value) {
            return ($value & 1);
        };
        $expecteds = ['a' => 1, 'c' => 3, 'e' => 5];

        $this->checkAttribute('filter', $origins, $expecteds, $closure);
    }

    public function testFlip()
    {
        $origins = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $expecteds = [1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e'];

        $this->checkAttribute('flip', $origins, $expecteds);
    }

    public function testIntersectAssoc()
    {
        $origins = ['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red'];
        $param = ['a' => 'green', 'b' => 'yellow', 'blue', 'red'];
        $expecteds = ['a' => 'green'];

        $this->checkAttribute('intersectAssoc', $origins, $expecteds, $param);
    }

    public function testIntersectKey()
    {
        $origins = ['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4];
        $param = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan' => 8];
        $expecteds = ['blue' => 1, 'green' => 3];

        $this->checkAttribute('intersectKey', $origins, $expecteds, $param);
    }

    public function testIntersectUassoc()
    {
        $origins = ['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red'];
        $param = ['a' => 'GREEN', 'B' => 'brown', 'yellow', 'red'];
        $expecteds = ['b' => 'brown'];

        $this->checkAttribute('intersectUassoc', $origins, $expecteds, $param, 'strcasecmp');
    }

    public function testIntersectUkey()
    {
        $origins = ['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4];
        $param = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan' => 8];
        $closure = function($key1, $key2) {
            if ($key1 == $key2) {
                return 0;
            } elseif ($key1 > $key2) {
                return 1;
            } else {
                return -1;
            }
        };
        $expecteds = ['blue' => 1, 'green' => 3];

        $this->checkAttribute('intersectUkey', $origins, $expecteds, $param, $closure);
    }

    public function testIntersect()
    {
        $origins = ['a' => 'green', 'red', 'blue'];
        $param = ['b' => 'green', 'yellow', 'red'];
        $expecteds = ['a' => 'green', 'red'];

        $this->checkAttribute('intersect', $origins, $expecteds, $param);
    }

    public function testKeyExists()
    {
        $origins = ['first' => 1, 'second' => 4];
        $expecteds = true;

        $this->checkReturnBool('keyExists', $origins, true, 'first');
        $this->checkReturnBool('keyExists', $origins, false, 'test');
    }

    // TODO: php >= 7.3
    // public function testKeyFirst()
    // {
    //     $origins = ['a' => 1, 'b' => 2, 'c' => 3];

    //     $this->checkReturnOther('keyFirst', $origins, 'a');
    // }

    // TODO: php >= 7.3
    // public function testKeyLast()
    // {
    //     $origins = ['a' => 1, 'b' => 2, 'c' => 3];

    //     $this->checkReturnOther('keyLast', $origins, 'c');
    // }

    public function testKeys()
    {
        $origins = ['blue', 'red', 'green', 'blue', 'blue', 'color' => 'blue'];
        $expecteds = [0, 3, 4, 'color'];

        $this->checkAttribute('keys', $origins, $expecteds, 'blue');
    }

    public function testMap()
    {
        $origins = [1, 2, 3, 4, 5];
        $expecteds = [1, 8, 27, 64, 125];
        $closure = function ($n) {
            return ($n * $n * $n);
        };

        $this->checkAttribute('map', $origins, $expecteds, $closure);
    }

    private function checkAttribute($func, $origins, $expecteds, ...$params)
    {
        $result = $this->commonCheck($func, $origins, $params);

        $this->assertInstanceOf(ArrayOoe::class, $result);

        $actual = $result->get();

        $this->assertEquals($expecteds, $actual);
    }

    private function checkReturnBool($func, $origins, $expecteds, ...$params)
    {
        $result = $this->commonCheck($func, $origins, $params);

        $expecteds ? $this->assertTrue($result) : $this->assertFalse($result);
    }

    private function checkReturnOther($func, $origins, $expecteds, ...$params)
    {
        $result = $this->commonCheck($func, $origins, $params);

        $this->assertEquals($expecteds, $result);
    }


    private function commonCheck($func, $origins, $params)
    {
        $instance = new ArrayOoe($origins);

        $this->assertInstanceOf(ArrayOoe::class, $instance);

        return $instance->{$func}(...$params);
    }
}
