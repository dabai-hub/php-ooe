<?php

namespace Hezalex\Ooe;

use Doctrine\Instantiator\Exception\InvalidArgumentException;


class Ooe
{
    /**
     * Ooe container
     *
     * @var mixed
     */
    protected $container;

    /**
     * Built-in method called
     *
     * @var string
     */
    private $builtInName = '';

    /**
     * ooe method called
     *
     * @var string
     */
    private $ooeName = '';

    /**
     * built-in functions mapping
     *
     * @var array
     */
    protected static $mapping = [];

    /**
     * execute the Ooe method
     *
     * @param array $params
     * @return mixed
     */
    private function execOoeMethod($params)
    {
        [$result, $option] = $this->execBuiltInFunction($this->ooeName, $params);

        if ($option) {
            return $result;
        }

        return new static($result);
    }

    /**
     * execute the specified built-in function
     *
     * @param  string $name
     * @param  array  $params
     * @return array
     */
    private function execBuiltInFunction(string $name, array $params)
    {
        $this->name = static::$mapping[$name][0];

        $pos = static::$mapping[$name][1];

        $option = static::$mapping[$name][2];

        $reference = static::$mapping[$name][3];

        // **** 0 数组在第一个位置 ****
        // **** 1 数组在第二个位置 ****
        // **** 2 数组在最后一个位置 ****
        // **** 3 不传数组 ****
        // 然后开始通过判断在下边的方法中操作 $this->container的位置

        set_error_handler([$this, 'errorHandler']);

        switch ($pos) {
            case 0:
                if ($reference) {
                    $result = call_user_func_array($this->name, array_merge([&$this->container], $params));
                } else {
                    $result = call_user_func($this->name, $this->container, ...$params);
                }
                break;
            case 1:
                array_splice($params, 1, 0, [$this->container]);
                $result = call_user_func_array($this->name, $params);
                break;
            case 2:
                array_push($params, $this->container);
            case 3:
                $result = call_user_func_array($this->name, $params);
                break;
            default:
                throw new InvalidArgumentException('Invalid pos value');
        }

        restore_error_handler();

        return [$result, $option];
    }

    /**
     * user-defined error handler function
     *
     * @param  integer $errno
     * @param  string  $errstr
     * @param  string  $errfile
     * @param  integer $errline
     * @return void
     */
    private function errorHandler(int $errno, string $errstr, string $errfile, int $errline)
    {
        switch ($errno) {
            case E_PARSE:
            case E_ERROR:
            case E_USER_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_RECOVERABLE_ERROR:
                $level = 'Fatal Error:';
                break;
            case E_WARNING:
            case E_USER_WARNING:
            case E_COMPILE_WARNING:
                $level = 'Warning:';
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
                $level = 'Notice:';
                break;
            case E_STRICT:
                $level = 'Strict:';
                break;
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                $level = 'Deprecated:';
                break;
            default:
                break;
        }

        $errstr = preg_replace("/{$this->name}/", $this->ooeName, $errstr);

        echo "{$level} {$errstr} in {$errfile} on line {$errline}" . PHP_EOL;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function __call($name, $params)
    {
        $this->ooeName = $name;

        return $this->execOoeMethod($params);
    }
}