<?php

declare (strict_types = 1);

namespace Hezalex\Ooe;

use Hezalex\Ooe\Traits\Help;

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
     * built-in functions mapping
     *
     * @var array
     */
    protected static $mapping = [
        'changeKeyCase' => ['func' => 'array_change_key_case', 'must' => 0, 'defaults' => [CASE_LOWER]],
        'chunk' => ['func' => 'array_chunk', 'must' => 1, 'defaults' => [false]],
        'column' => ['func' => 'array_column', 'must' => 1, 'defaults' => [null]],
        'combine' => ['func' => 'array_combine', 'must' => 1, 'defaults' => []],
        'countValues' => ['func' => 'array_count_values', 'must' => 0, 'defaults' => []],
        'diffAssoc' => ['func' => 'array_diff_assoc', 'must' => 2, 'defaults' => []],
        'diffKey' => ['func' => 'array_diff_key', 'must' => 2, 'defaults' => []],
        'diffUassoc' => ['func' => 'array_diff_uassoc', 'must' => 2, 'defaults' => []], // TODO: 这里需要再看下怎么封装 回调在最后一个位置
        'diffUkey' => ['func' => 'array_diff_ukey', 'must' => 2, 'defaults' => []],
    ];

    /**
     * Deprecated built-in funcitons
     *
     * @var array
     */
    private $deprecated = [

    ];

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
     * Alias of the get method
     *
     * @return array
     */
    public function toArray() : array
    {
        return $this->get();
    }

    /**
     * get array length
     *
     * @return integer
     */
    public function count() : int
    {
        return count($this->array);
    }

    public function execOoeMethod($name, $params)
    {
        $array = $this->execBuiltInFunction($name, $params);

        // TODO: 判断返回值是否为数组，如果是则实例化带参数 不是的话 再写逻辑

        return new static($array);
    }

    /**
     * execute the specified built-in function
     *
     * @param  string $name
     * @param  array  $params
     * @return array
     */
    private function execBuiltInFunction($name, $params)
    {
        $name = self::$mapping[$name]['func'];

        return call_user_func($name, $this->array, ...$params);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function __call($name, $params)
    {
        $params = func_get_arg(1);

        $must = self::$mapping[$name]['must'];

        $defaults = self::$mapping[$name]['defaults'];

        $musts = [];

        if (array_key_exists($name, self::$mapping)) {

            if ($must) {
                // 所传参数小于必传参数个数时 抛出异常
                if (count($params) < $must) {
                    throw new \BadMethodCallException ("the method {$name} was passed with the wrong parameter");
                }

                $musts = array_slice($params, 0, $must);

                $params = array_slice($params, $must - 1);
            }

            // The entered parameters override the default values
            $covers = $params + $defaults;

            array_push($musts, ...$covers);

            return $this->execOoeMethod($name, $musts);
        } else {
            throw new \BadMethodCallException ("the method {$name} is undefined");
        }
    }
}