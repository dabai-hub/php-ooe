<?php

declare (strict_types = 1);

namespace Hezalex\Ooe;

use Closure;
use Countable;
use ArrayAccess;
use Traversable;
use JsonSerializable;
use IteratorAggregate;
use Hezalex\Ooe\Traits\Help;

class ArrayOoe extends Ooe implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    /**
     * This array is not an objectified array
     *
     * @var array
     */
    protected $container = [];

    /**
     * built-in functions mapping
     *
     * @var array
     */
    protected static $mapping = [
        'changeKeyCase' => 'array_change_key_case',
        'chunk' => 'array_chunk',
        'column' =>'array_column',
        'combine' => 'array_combine',
        'countValues' => 'array_count_values',
        'diffAssoc' => 'array_diff_assoc',
        'diffKey' =>'array_diff_key',
        'diffUassoc' => 'array_diff_uassoc',
        'diffUkey' => 'array_diff_ukey',
        'diff' => 'array_diff',
        'fillKeys' => 'array_fill_keys',
        'fill' => 'array_fill',
        'filter' => 'array_filter',
        'flip' => 'array_flip',
        'intersectAssoc' => 'array_intersect_assoc',
        'intersectKey' => 'array_intersect_key',
        'intersectUassoc' => 'array_intersect_uassoc',
        'intersectUkey' => 'array_intersect_ukey',
        'intersect' => 'array_intersect',
        'keyExists' => 'array_key_exists',
        'keyFirst' => 'array_key_first',
        'keyLast' => 'array_key_last',
        'keys' => 'array_keys',
        'map' => 'array_map',
        'mergeRecursive' => 'array_merge_recursive',
        'merge' => 'array_merge',
        'multisort' => 'array_multisort',
        'pad' => 'array_pad',
        'pop' => 'array_pop',
        'product' => 'array_product',
        'push' => 'array_push',
        'rand' => 'array_rand',
        'reduce' => 'array_reduce',
        'replaceRecursive' => 'array_replace_recursive',
        'replace' => 'array_replace',
        'reverse' => 'array_reverse',
        'search' => 'array_search',
        'shift' => 'array_shift',
        'slice' => 'array_slice',
        'splice' => 'array_splice',
        'sum' => 'array_sum',
        'udiffAssoc' => 'array_udiff_assoc',
        'udiffUassoc' => 'array_udiff_uassoc',
        'udiff' => 'array_udiff',
        'uintersect_assoc' => ' array_uintersect_assoc',
        'uintersect_uassoc' => 'array_uintersect_assoc',
        'uintersect' => 'array_uintersect',
        'unique' => 'array_unique',
        'unshift' => 'array_unshift',
        'values' => 'array_values',
        'walkRecursive' => 'array_walk_recursive',
        'walk' => 'array_walk',
        'array' => 'array',
        'arsort' => 'arsort',
        'asort' => 'asort',
        'compact' => 'compact',
        // 'count' => 'count',
        'current' => 'current',
        'end' => 'end',
        'extract' => 'extract',
        'inArray' => 'in_array',
        'keyExists' => 'key_exists',
        'key' => 'key',
        'krsort' => 'krsort',
        'ksort' => 'ksort',
        'list' => 'list',
        'natcasesort' => 'natcasesort',
        'natsort' => 'natsort',
        'next' => 'next',
        'pos' => 'pos',
        'prev' => 'prev',
        'range' => 'range',
        'reset' => 'reset',
        'rsort' => 'rsort',
        'shuffle' => 'shuffle',
        'sizeof' => 'sizeof',
        'sort' => 'sort',
        'uasort' => 'uasort',
        'uksort' => 'uksort',
        'usort' => 'usort',
        'each' => 'each',
    ];

    /**
     * Deprecated built-in funcitons
     *
     * @var array
     */
    private $deprecated = [];

    /**
     * Attribute assignment
     *
     * @param  array  $array
     * @return void
     */
    public function __construct(array $array = [])
    {
        $this->container = $array;
    }

    /**
     * return array
     *
     * @return array
     */
    public function get() : array
    {
        return $this->container;
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
        return count($this->container);
    }

    /**
     * Whether an offset exists
     *
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset) : boolean
    {
        return isset($this->container[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset) : mixed
    {
        return $this->container[$offset];
    }

    /**
     * Assign a value to the specified offset
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value) : void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unset an offset
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset) : void
    {
        unset($this->container[$offset]);
    }

    /**
     * Retrieve an external iterator
     *
     * @return Traversable
     */
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->container);
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function jsonSerialize() : mixed
    {
        // TODO:
    }

    /**
     * array to json
     *
     * @param  integer $options
     * @param  integer $depth
     * @return string
     */
    public function toJson(int $options = 0, int $depth = 512) : string
    {
        return json_encode($this->item, $options, $depth);
    }

    /**
     * object to string
     *
     * @return string
     */
    public function __toString()
    {
        $this->toJson();
    }

    /**
     * User-defined method
     *
     * @param Closure $closure
     * @return void
     */
    public function customer(Closure $closure)
    {
        $closure->bindTo($this);

        $result = $closure($this->container);

        // TODO: 在这里判断是否把返回结果赋值给 $this->container 还是直接返回
    }
}