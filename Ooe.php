<?php

namespace Hezalex\Ooe;

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

    private function execOoeMethod($params)
    {
        $container = $this->execBuiltInFunction($this->ooeName, $params);

        // TODO: 判断返回值的类型，然后决定返回值是什么 现在暂且将其当做操作后返回的原类型

        return new static($container);
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
        $this->name = static::$mapping[$name];

        // TODO: 有些方法不需要传递数组 或者数组在最后一个位置，这里需要解决下

        set_error_handler([$this, 'errorHandler']);

        $result = call_user_func($this->name, $this->container, ...$params);

        restore_error_handler();

        return $result;
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