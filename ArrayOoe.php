<?php declare (strict_types = 1);

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
     * Array parameter description:
     *
     * @param string $name: Corresponding PHP built-in function name.
     * @param int    $pos: The position of the manipulated array in the built-in function. 0 is first, 1 is second, 2 is last, 3 instructions do not pass array.
     * @param bool   $option: Whether the return value give to Ooe attribute or just return. 0 return to attribute, 1 return.
     * @param bool   $reference: Whether the array is a reference type.
     *
     * @var array
     */
    protected static $mapping = [
        'changeKeyCase' => ['array_change_key_case', 0, 0, 0],
        'chunk' => ['array_chunk', 0, 0, 0],
        'column' => ['array_column', 0, 0, 0],
        'combine' => ['array_combine', 0, 0, 0],
        'countValues' => ['array_count_values', 0, 0, 0],
        'diffAssoc' => ['array_diff_assoc', 0, 0, 0],
        'diffKey' => ['array_diff_key', 0, 0, 0],
        'diffUassoc' => ['array_diff_uassoc', 0, 0, 0],
        'diffUkey' => ['array_diff_ukey', 0, 0, 0],
        'diff' => ['array_diff', 0, 0, 0],
        'fillKeys' => ['array_fill_keys', 0, 0, 0],
        'fill' => ['array_fill', 3, 0, 0],
        'filter' => ['array_filter', 0, 0, 0],
        'flip' => ['array_flip', 0, 0, 0],
        'intersectAssoc' => ['array_intersect_assoc', 0, 0, 0],
        'intersectKey' => ['array_intersect_key', 0, 0, 0],
        'intersectUassoc' => ['array_intersect_uassoc', 0, 0, 0],
        'intersectUkey' => ['array_intersect_ukey', 0, 0, 0],
        'intersect' => ['array_intersect', 0, 0, 0],
        'keyExists' => ['array_key_exists', 2, 1, 0],
        'keyFirst' => ['array_key_first', 0, 0, 0],
        'keyLast' => ['array_key_last', 0, 0, 0],
        'keys' => ['array_keys', 0, 0, 0],
        'map' => ['array_map', 1, 0, 0],
        'mergeRecursive' => ['array_merge_recursive', 0, 0, 0],
        'merge' => ['array_merge', 0, 0, 0],
        // 'multisort' => ['array_multisort', 0, 0, 1],
        'pad' => ['array_pad', 0, 0, 0],
        'pop' => ['array_pop', 0, 1, 1],
        'product' => ['array_product', 0, 1, 0],
        'push' => ['array_push', 0, 1, 1],
        'rand' => ['array_rand', 0, 1, 0],
        'reduce' => ['array_reduce', 0, 1, 0],
        'replaceRecursive' => ['array_replace_recursive', 0, 0, 0],
        'replace' => ['array_replace', 0, 0, 0],
        'reverse' => ['array_reverse', 0, 0, 0],
        'search' => ['array_search', 2, 1, 0],
        'shift' => ['array_shift', 0, 1, 1],
        'slice' => ['array_slice', 0, 0, 0],
        'splice' => ['array_splice', 0, 1, 1],
        'sum' => ['array_sum', 0, 1, 0],
        'udiffAssoc' => ['array_udiff_assoc', 0, 0, 0],
        'udiffUassoc' => ['array_udiff_uassoc', 0, 0, 0],
        'udiff' => ['array_udiff', 0, 0, 0],
        'uintersectAssoc' => ['array_uintersect_assoc', 0, 0, 0],
        'uintersectUassoc' => ['array_uintersect_uassoc', 0, 0, 0],
        'uintersect' => ['array_uintersect', 0, 0, 0],
        'unique' => ['array_unique', 0, 0, 0],
        'unshift' => ['array_unshift', 0, 1, 1],
        'values' => ['array_values', 0, 0, 0],
        'walkRecursive' => ['array_walk_recursive', 0, 1, 1],
        'walk' => ['array_walk', 0, 1, 1],
        // 'array' => ['array', 0], // 暂不支持
        'arsort' => ['arsort', 0, 1, 1],
        'asort' => ['asort', 0, 1, 1],
        // 'compact' => ['compact', 3, 0, 0], // 暂不支持
        // 'count' => ['count', 0], // 类中含有此方法
        'current' => ['current', 0, 1, 1],
        'end' => ['end', 0, 1, 1],
        // 'extract' => ['extract', 0, 1, 1], // 暂不支持
        'inArray' => ['in_array', 2, 1, 0],
        // 'keyExists2' => ['key_exists', 2], // 先不实现 因为重复了
        'key' => ['key', 0, 1, 0],
        'krsort' => ['krsort', 0, 1, 1],
        'ksort' => ['ksort', 0, 1, 1],
        // 'list' => 'list', // 暂不支持
        'natcasesort' => ['natcasesort', 0, 1, 1],
        'natsort' => ['natsort', 0, 1, 1],
        'next' => ['next', 0, 1, 1],
        'pos' => ['pos', 0, 1, 1],
        'prev' => ['prev', 0, 1, 1],
        // 'range' => 'range', // 暂不支持
        'reset' => ['reset', 0],
        'rsort' => ['rsort', 0],
        'shuffle' => ['shuffle', 0],
        'sizeof' => ['sizeof', 0],
        'sort' => ['sort', 0],
        'uasort' => ['uasort', 0],
        'uksort' => ['uksort', 0],
        'usort' => ['usort', 0],
        'each' => ['each', 0],
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
    // public function array(...$array) : self
    // {
    //     return new static($array);
    // }

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
