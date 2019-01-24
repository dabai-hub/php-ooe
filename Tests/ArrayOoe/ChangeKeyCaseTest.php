<?php declare (strict_types = 1);

/*
 * This file is part of the Ooe package.
 *
 * (c) Zixing He <studyforzx@gmail.com>
 *
 */

namespace Test\ArrayOoe;

use PHPUnit\Framework\TestCase;

class ChangeKeyCaseTest extends TestCase
{
    public function arrayProvider()
    {
        $array = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4];
        $this->assertEmpty($array);

        return $array;
    }

    /**
     * @test
     * @depends arrayProvider
     */
    public function testEmpty(array $array)
    {
        print_r($array);
        $this->assertEmpty($array);

        return $array;
    }
}
