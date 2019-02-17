<?php declare (strict_types = 1);

/*
 * This file is part of the Ooe package.
 *
 * (c) Zixing He <studyforzx@gmail.com>
 *
 */

namespace Test\ArrayOoe;

use stdclass;
use Hezalex\Ooe\ArrayOoe;
use PHPUnit\Framework\TestCase;

class ArrayOoeTest extends TestCase
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
        $origins = ['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4];
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
        $closure = function ($key1, $key2) {
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

        $this->checkReturnBool('keyExists', $origins, true, $origins, 'first');
        $this->checkReturnBool('keyExists', $origins, false, $origins, 'test');
    }

    // TODO: php >= 7.3
    public function testKeyFirst()
    {
        if (PHP_VERSION_ID < 70300) {
            $this->markTestSkipped('PHP version is greater than 7.3 to support keyFirst method');
        }

        $origins = ['a' => 1, 'b' => 2, 'c' => 3];

        $this->checkReturnOther('keyFirst', $origins, 'a', $origins);
    }

    // TODO: php >= 7.3
    public function testKeyLast()
    {
        if (PHP_VERSION_ID < 70300) {
            $this->markTestSkipped('PHP version is greater than 7.3 to support keyFirst method');
        }

        $origins = ['a' => 1, 'b' => 2, 'c' => 3];

        $this->checkReturnOther('keyLast', $origins, 'c', $origins);
    }

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

    public function testMergeRecursive()
    {
        $origins = ['color' => ['favorite' => 'red'], 5];
        $param = [10, 'color' => ['favorite' => 'green', 'blue']];
        $expecteds = ['color' => ['favorite' => ['red', 'green'], 'blue'], 5, 10];

        $this->checkAttribute('mergeRecursive', $origins, $expecteds, $param);
    }

    public function testMerge()
    {
        $origins = ['color' => 'red', 2, 4];
        $param = ['a', 'b', 'color' => 'green', 'shape' => 'trapezoid', 4];
        $expecteds = ['color' => 'green', 2, 4, 'a', 'b', 'shape' => 'trapezoid', 4];

        $this->checkAttribute('merge', $origins, $expecteds, $param);
    }

    // public function testmultisort()
    // {
    //     $origins = [10, 100, 100, 0];
    //     $param = [1, 3, 2, 4];

    //     $instance = new ArrayOoe($origins);

    //     $this->assertInstanceOf(ArrayOoe::class, $instance);

    //     $instance->multisort($param);

    //     $this->assertEquals([0, 10, 100, 100], $instance->get());
    //     $this->assertEquals([4, 1, 2, 3], $param);
    // }

    public function testPad()
    {
        $origins = [12, 10, 9];
        $size = 5;
        $value = 0;
        $expecteds = [12, 10, 9, 0, 0];

        $this->checkAttribute('pad', $origins, $expecteds, $size, $value);
    }

    public function testPop()
    {
        $origins = ['orange', 'banana', 'apple', 'raspberry'];
        $expecteds = 'raspberry';
        $attribute = ['orange', 'banana', 'apple'];

        $this->checkReturnOther('pop', $origins, $expecteds, $attribute);
    }

    public function testProduct()
    {
        $origins = [2, 4, 6, 8];
        $expecteds = 384;

        $this->checkReturnOther('product', $origins, $expecteds, $origins);
    }

    public function testPush()
    {
        $origins = ['orange', 'banana'];
        $param = ['apple', 'banana'];
        $expecteds = 4;
        $attribute = ['orange', 'banana', 'apple', 'banana'];

        $this->checkReturnOther('push', $origins, $expecteds, $attribute, ...$param);
    }

    public function testRand()
    {
        $origins = ['Neo', 'Morpheus', 'Trinity', 'Cypher', 'Tank'];
        $params = [2];

        [$instance, $result] = $this->commonCheck('rand', $origins, $params, true);

        $this->assertInstanceOf(ArrayOoe::class, $instance);

        $actual = $instance->get();

        $this->assertContains($origins[$result[0]], $actual);
        $this->assertContains($origins[$result[1]], $actual);
    }

    public function testReduce()
    {
        $origins = [1, 2, 3, 4, 5];
        $closure = function ($carry, $item) {
            $carry += $item;
            return $carry;
        };
        $expecteds = 15;

        $this->checkReturnOther('reduce', $origins, $expecteds, $origins, $closure);
    }

    public function testReplaceRecursive()
    {
        $origins = ['citrus' => ['orange'], 'berries' => ['blackberry', 'raspberry']];
        $param = ['citrus' => ['pineapple'], 'berries' => ['blueberry']];
        $expecteds = ['citrus' => ['pineapple'], 'berries' => ['blueberry', 'raspberry']];

        $this->checkAttribute('replaceRecursive', $origins, $expecteds, $param);
    }

    public function testReplace()
    {
        $origins = ['orange', 'banana', 'apple', 'raspberry'];
        $param1 = ['pineapple', 4 => 'cherry'];
        $param2 = ['grape'];
        $expecteds = ['grape', 'banana', 'apple', 'raspberry', 'cherry'];

        $this->checkAttribute('replace', $origins, $expecteds, $param1, $param2);
    }

    public function testReverse()
    {
        $origins = ['php', 4.0, ['green', 'red']];
        $param = true;
        $expecteds1 = [['green', 'red'], 4, 'php'];
        $expecteds2 = [2 => ['green', 'red'], 1 => 4, 0 => 'php'];

        $this->checkAttribute('reverse', $origins, $expecteds1);
        $this->checkAttribute('reverse', $origins, $expecteds2, $param);
    }

    public function testSearch()
    {
        $origins = ['blue', 'red', 'green', 'red'];
        $needle = 'red';
        $expecteds = 1;

        $this->checkReturnOther('search', $origins, $expecteds, $origins, $needle);
    }

    public function testShift()
    {
        $origins = ['orange', 'banana', 'apple', 'raspberry'];
        $attribute = ['banana', 'apple', 'raspberry'];
        $expecteds = 'orange';

        $this->checkReturnOther('shift', $origins, $expecteds, $attribute);
    }

    public function testSlice()
    {
        $origins = ['a', 'b', 'c', 'd', 'e'];
        $offset = 2;
        $lenght = -1;
        $preserveKey = true;
        $expecteds = [2 => 'c', 3 => 'd'];

        $this->checkAttribute('slice', $origins, $expecteds, $offset, $lenght, $preserveKey);
    }

    public function testSplice()
    {
        $origins = ['red', 'green', 'blue', 'yellow'];
        $offset = -1;
        $lenght = 1;
        $replacement = ['black', 'maroon'];
        $attribute = ['red', 'green', 'blue', 'black', 'maroon'];
        $expecteds = ['yellow'];

        $this->checkReturnOther('splice', $origins, $expecteds, $attribute, $offset, $lenght, $replacement);
    }

    public function testSum()
    {
        $origins = [2, 4, 6, 8];
        $expecteds = 20;

        $this->checkReturnOther('sum', $origins, $expecteds, $origins);
    }

    public function testUdiffAssoc()
    {
        $origins = ['0.1' => 9, '0.5' => 12, 0 => 23, 1 => 4, 2 => -15];
        $param = ['0.2' => 9, '0.5' => 22, 0 => 3, 1 => 4, 2 => -15];
        $closure = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }

            return ($a > $b) ? 1 : -1;
        };
        $expecteds = ['0.1' => 9, '0.5' => 12, 0 => 23];

        $this->checkAttribute('udiffAssoc', $origins, $expecteds, $param, $closure);
    }

    public function testUdiffUassoc()
    {
        $origins = ['0.1' => 9, '0.5' => 12, 0 => 23, 1 => 4, 2 => -15];
        $param = ['0.2' => 9, '0.5' => 22, 0 => 3, 1 => 4, 2 => -15];
        $closure = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }

            return ($a > $b) ? 1 : -1;
        };
        $expecteds = ['0.1' => 9, '0.5' => 12, 0 => 23];

        $this->checkAttribute('udiffUassoc', $origins, $expecteds, $param, $closure, $closure);
    }

    public function testUdiff()
    {
        $origins = [new stdclass, new stdclass, new stdclass, new stdclass];
        $param = [new stdclass, new stdclass];

        $origins[0]->width = 11;
        $origins[0]->height = 3;
        $origins[1]->width = 7;
        $origins[1]->height = 1;
        $origins[2]->width = 2;
        $origins[2]->height = 9;
        $origins[3]->width = 5;
        $origins[3]->height = 7;

        $param[0]->width = 7;
        $param[0]->height = 5;
        $param[1]->width = 9;
        $param[1]->height = 2;

        $closure = function ($a, $b)
        {
            $areaA = $a->width * $a->height;
            $areaB = $b->width * $b->height;

            if ($areaA < $areaB) {
                return -1;
            } elseif ($areaA > $areaB) {
                return 1;
            } else {
                return 0;
            }
        };

        $expecteds = [new stdclass, new stdclass];
        $expecteds[0]->width = 11;
        $expecteds[0]->height = 3;
        $expecteds[1]->width = 7;
        $expecteds[1]->height = 1;

        $this->checkAttribute('udiff', $origins, $expecteds, $param, $closure);
    }

    public function testUintersectAssoc()
    {
        $origins = ['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red'];
        $param = ['a' => 'GREEN', 'B' => 'brown', 'yellow', 'red'];
        $expecteds = ['a' => 'green'];

        $this->checkAttribute('uintersectAssoc', $origins, $expecteds, $param, 'strcasecmp');
    }

    public function testUintersectUassoc()
    {
        $origins = ['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red'];
        $param = ['a' => 'GREEN', 'B' => 'brown', 'yellow', 'red'];
        $expecteds = ['a' => 'green', 'b' => 'brown'];

        $this->checkAttribute('uintersectUassoc', $origins, $expecteds, $param, 'strcasecmp', 'strcasecmp');
    }

    public function testUintersect()
    {
        $origins = ['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red'];
        $param = ['a' => 'GREEN', 'B' => 'brown', 'yellow', 'red'];
        $expecteds = ['a' => 'green', 'b' => 'brown', 0 => 'red'];

        $this->checkAttribute('uintersect', $origins, $expecteds, $param, 'strcasecmp');
    }

    public function testUnique()
    {
        $origins = ['a' => 'green', 'red', 'b' => 'green', 'blue', 'red'];
        $expecteds = ['a' => 'green', 'red', 'blue'];

        $this->checkAttribute('unique', $origins, $expecteds);
    }

    public function testUnshift()
    {
        $origins = ['orange', 'banana'];
        $param1 = 'apple';
        $param2 = 'raspberry';
        $expecteds = 4;
        $attribute = ['apple', 'raspberry', 'orange', 'banana'];

        $this->checkReturnOther('unshift', $origins, $expecteds, $attribute, $param1, $param2);
    }

    public function testValues()
    {
        $origins = ['size' => 'XL', 'color' => 'gold'];
        $expecteds = ['XL', 'gold'];

        $this->checkAttribute('values', $origins, $expecteds);
    }

    public function testWalkRecursive()
    {
        $origins = ['sweet' => ['a' => 'apple', 'b' => 'banana'], 'sour' => 'lemon'];

        $result = '';

        $closure = function ($item, $key) use (&$result) {
            $result .= "$key holds $item ";
        };
        $expecteds1 = true;
        $expecteds2 = 'a holds apple b holds banana sour holds lemon ';

        $this->checkReturnOther('walkRecursive', $origins, $expecteds1, $origins, $closure);
        $this->assertEquals($result, $expecteds2);
    }

    public function testWalk()
    {
        $origins = ['d' => 'lemon', 'a' => 'orange', 'b' => 'banana', 'c' => 'apple'];
        $result = '';
        $closure = function ($item, $key) use (&$result) {
            $result .= "$key. $item ";
        };
        $expecteds1 = true;
        $expecteds2 = 'd. lemon a. orange b. banana c. apple ';

        $this->checkReturnOther('walk', $origins, $expecteds1, $origins, $closure);
        $this->assertEquals($result, $expecteds2);
    }

    // public function testArray()
    // {
    //     $origins = [1, 2, 3, 4];

    //     $instance = new ArrayOoe($origins);

    //     $this->assertInstanceOf(ArrayOoe::class, $instance);

    //     $instance->array(1, 1, 1, 1);

    //     $this->assertEquals($instance->get(), [1, 1, 1, 1]);
    // }

    public function testArsort()
    {
        $origins = ['d' => 'lemon', 'a' => 'orange', 'b' => 'banana', 'c' => 'apple'];
        $expecteds = true;
        $attribute = ['a' => 'orange', 'd' => 'lemon', 'b' => 'banana', 'c' => 'apple'];

        $this->checkReturnOther('arsort', $origins, $expecteds, $attribute);
    }

    public function testAsort()
    {
        $origins = ['d' => 'lemon', 'a' => 'orange', 'b' => 'banana', 'c' => 'apple'];
        $expecteds = true;
        $attribute = ['c' => 'apple', 'b' => 'banana', 'd' => 'lemon', 'a' => 'orange'];

        $this->checkReturnOther('asort', $origins, $expecteds, $attribute);
    }

    // public function testCompact()
    // {
    //     $origins = [];
    //     $city  = "San Francisco";
    //     $state = "CA";
    //     $event = "SIGGRAPH";
    //     $locationVars = array("city", "state");
    //     $expecteds = ['event' => 'SIGGRAPH', 'city' => 'San Francisco', 'state' => 'CA'];

    //     $this->checkAttribute('compact', $origins, $expecteds, 'city', 'nothing_here', $locationVars);
    // }

    private function checkAttribute($func, $origins, $expecteds, ...$params)
    {
        $result = $this->commonCheck($func, $origins, $params);

        $this->assertInstanceOf(ArrayOoe::class, $result);

        $actual = $result->get();

        $this->assertEquals($expecteds, $actual);
    }

    private function checkReturnBool($func, $origins, $expecteds, $attribute, ...$params)
    {
        [$instance, $result] = $this->commonCheck($func, $origins, $params, true);

        $expecteds ? $this->assertTrue($result) : $this->assertFalse($result);

        $this->assertEquals($attribute, $instance->get());
    }

    private function checkReturnOther($func, $origins, $expecteds, $attribute, ...$params)
    {
        [$instance, $result] = $this->commonCheck($func, $origins, $params, true);

        $this->assertEquals($expecteds, $result);

        $this->assertEquals($instance->get(), $attribute);
    }

    private function commonCheck($func, $origins, $params, $options = false)
    {
        $instance = new ArrayOoe($origins);

        $this->assertInstanceOf(ArrayOoe::class, $instance);

        $result = $instance->{$func}(...$params);

        if ($options) {
            return [$instance, $result];
        }

        return $result;
    }
}
