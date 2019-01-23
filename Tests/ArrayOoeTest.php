<?php

declare (strict_types = 1);

use PHPUnit\Framework\TestCase;

class ArrayOoeTest extends TestCase
{

    /**
     * Provider original data
     *
     * @return array
     */
    public function arrayProvider()
    {
        return ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testChangeKeyCase()
    {

    }
}