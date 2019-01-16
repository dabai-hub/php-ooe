<?php

declare(strict_types = 1);

namespace Hezalex\Ooe;

class ArrayOoe
{

    /**
     * This array is not an objectified array
     *
     * @var array
     */
    protected $array = [];

    /**
     * Attribute assignment
     *
     * @param  array  $array
     * @return void
     */
    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    /**
     * array_change_key_case — Changes the case of all keys in an array
     *
     * @link http://php.net/manual/en/function.array-change-key-case.php
     * @param  int  $case
     * @return void
     */
    public function changeKeyCase(int $case = CASE_LOWER)
    {
        // Method supported version
        $this->checkMethodVersion([
            ['PHP 4', '>=', '4.2.0'],
            ['PHP5'],
            ['PHP7'],
        ]);


        array_change_key_case($this->array, $case);
    }

    /**
     * Check if the current php version supports the current method
     *
     * @param [type] $version
     * @return void
     */
    private function checkMethodVersion($version)
    {

    }
}