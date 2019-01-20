<?php

namespace Hezalex\Ooe;

class Ooe
{
    /**
     * built-in functions mapping
     *
     * @var array
     */
    protected static $mapping = [];

    private function execOoeMethod($name, $params)
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
    public function __callStatic($name, $params)
    {
        $params = func_get_arg(1);

        $must = self::$mapping[$name]['must'];

        $defaults = self::$mapping[$name]['defaults'];

        $musts = [];

        if (array_key_exists($name, self::$mapping)) {

            if ($must) {
                // 所传参数小于必传参数个数时 抛出异常
                if (count($params) < $must) {
                    throw new \BadMethodCallException("the method {$name} was passed with the wrong parameter");
                }

                $musts = array_slice($params, 0, $must);

                $params = array_slice($params, $must - 1);
            }

            // The entered parameters override the default values
            $covers = $params + $defaults;

            array_push($musts, ...$covers);

            return $this->execOoeMethod($name, $musts);
        } else {
            throw new \BadMethodCallException("the method {$name} is undefined");
        }
    }
}