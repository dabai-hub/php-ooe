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
        'changeKeyCase' => ['func' => 'array_change_key_case', 'defaults' => [CASE_LOWER]],
        'chunk' => 'array_chunk',
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
        if (array_key_exists($name, self::$mapping)) {

            $params = func_get_arg(1);

            $defaults = self::$mapping[$name]['defaults'];

            // The entered parameters override the default values
            $covers = $params + $defaults;

            return $this->execOoeMethod($name, $covers);
        } else {
            throw new \BadMethodCallException ("the method {$name} is undefined");
        }
    }
}