<?php

declare (strict_types = 1);

namespace Hezalex\Ooe;

use Traits\Help;

class ArrayOoe
{
    use Help;

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
     * return array
     *
     * @return array
     */
    public function get() : array
    {
        return $this->array;
    }

    /**
     * Changes the case of all keys in an array
     *
     * @link http://php.net/manual/en/function.array-change-key-case.php
     *
     * @param  int  $case
     * @return void
     */
    public function changeKeyCase(int $case = CASE_LOWER) : ?array
    {
        $array = array_change_key_case($this->array, $case);

        return new static($array);
    }

    public function chunk(int $size, bool $preserveKeys = false) : array
    {
        array_chunk($this->array, $preserveKeys);
    }
}