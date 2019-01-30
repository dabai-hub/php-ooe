<?php

declare (strict_types = 1);

namespace Hezalex\Ooe;

use Closure;
use Countable;
use ArrayAccess;
use Traversable;
use JsonSerializable;
use IteratorAggregate;

class ArrayOoe extends Ooe implements ArrayAccess, Countable, IteratorAggregate
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
        'changeKeyCase' => ['array_change_key_case', 1],
        'chunk' => ['array_chunk', 1],
        'column' => ['array_column', 1],
        'combine' => ['array_combine', 0],
        'countValues' => ['array_count_values', 1],
        'diffAssoc' => ['array_diff_assoc', 0],
        'diffKey' => ['array_diff_key', 0],
        'diffUassoc' => ['array_diff_uassoc', 0],
        'diffUkey' => ['array_diff_ukey', 0],
        'diff' => ['array_diff', 0],
        'fillKeys' => ['array_fill_keys', 0],
        'fill' => ['array_fill', 0],
        'filter' => ['array_filter', 1],
        'flip' => ['array_flip', 1],
        'intersectAssoc' => ['array_intersect_assoc', 0],
        'intersectKey' => ['array_intersect_key', 0],
        'intersectUassoc' => ['array_intersect_uassoc', 0],
        'intersectUkey' => ['array_intersect_ukey', 0],
        'intersect' => ['array_intersect', 0],
        'keyExists' => ['array_key_exists', 2],
        'keyFirst' => ['array_key_first', 1],
        'keyLast' => ['array_key_last', 1],
        'keys' => ['array_keys', 1],
        'map' => ['array_map', 3],
        'mergeRecursive' => ['array_merge_recursive', 0],
        'merge' => ['array_merge', 0],
        'multisort' => ['array_multisort', 1],
        'pad' => ['array_pad', 1],
        'pop' => ['array_pop', 1],
        'product' => ['array_product', 1],
        'push' => ['array_push', 1],
        'rand' => ['array_rand', 1],
        'reduce' => ['array_reduce', 1],
        'replaceRecursive' => ['array_replace_recursive', 0],
        'replace' => ['array_replace', 0],
        'reverse' => ['array_reverse', 1],
        'search' => ['array_search', 3],
        'shift' => ['array_shift', 1],
        'slice' => ['array_slice', 1],
        'splice' => ['array_splice', 1],
        'sum' => ['array_sum', 1],
        'udiffAssoc' => ['array_udiff_assoc', 0],
        'udiffUassoc' => ['array_udiff_uassoc', 0],
        'udiff' => ['array_udiff', 0],
        'uintersectAssoc' => ['array_uintersect_assoc', 0],
        'uintersectUassoc' => ['array_uintersect_uassoc', 0],
        'uintersect' => ['array_uintersect', 0],
        'unique' => ['array_unique', 1],
        'unshift' => ['array_unshift', 1],
        'values' => ['array_values', 1],
        'walkRecursive' => ['array_walk_recursive', 1],
        'walk' => ['array_walk', 1],
        // 'array' => ['array', 0], // TODO: 实现方式： 直接写函数
        'arsort' => ['arsort', 1],
        'asort' => ['asort', 1],
        'compact' => ['compact', 0],
        // 'count' => ['count', 1], // 类中含有此方法
        'current' => ['current', 1],
        'end' => ['end', 1],
        'extract' => ['extract', 1],
        'inArray' => ['in_array', 3],
        'keyExists' => ['key_exists', 2],
        'key' => ['key', 1],
        'krsort' => ['krsort', 1],
        'ksort' => ['ksort', 1],
        // 'list' => 'list', // 暂不支持
        'natcasesort' => ['natcasesort', 1],
        'natsort' => ['natsort', 1],
        'next' => ['next', 1],
        'pos' => ['pos', 1],
        'prev' => ['prev', 1],
        // 'range' => 'range', // 暂不支持
        'reset' => ['reset', 1],
        'rsort' => ['rsort', 1],
        'shuffle' => ['shuffle', 1],
        'sizeof' => ['sizeof', 1],
        'sort' => ['sort', 1],
        'uasort' => ['uasort', 1],
        'uksort' => ['uksort', 1],
        'usort' => ['usort', 1],
        'each' => ['each', 1],
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
     * rebuild the value of container of array
     *
     * @param array $array
     * @return ArrayOoe
     */
    public function array(array $array)
    {
        return new static($array);
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
        // TODO: 需要改进下
        return $this->toJson();
    }

    /**
     * User-defined method
     *
     * @param  Closure $closure
     * @param  boolean $option
     * @return mixed
     */
    public function customer(Closure $closure, bool $option = false)
    {
        $closure->bindTo($this);

        $result = $closure($this->container);

        // if $option is true then return the result or return the class instance
        // this is for improving method flexibility.
        if ($option) {
            return $result;
        }

        $this->container = $result;

        return new static($this->container);
    }
}