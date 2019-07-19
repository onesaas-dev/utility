<?php namespace OneSaas\Components\Utility\Repository;

/**
 * Configuration Package
 *
 * Copyright (c) 2019 Elixant Technology Ltd.
 *
 * @package     OneSaas\Config
 * @copyright   2019 (c) Elixant Technology Ltd
 * @license     MIT License
 * @author      Alexander Schmautz <ceo@elixant.ca>
 * @filesource
 */
use OneSaas\Components\Utility\Arr;
use OneSaas\Components\Utility\Traits\Dumpable;

abstract class AbstractRepository
{
    use Dumpable;

    /**
     * All of the repository items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Determine if the given repository item exists.
     *
     * @param  string  $item
     * @return bool
     */
    abstract public function has($item);

    /**
 * Get the specified repository item.
 *
 * @param  array|string  $key
 * @param  mixed         $default
 * @return mixed
 */
    abstract public function get($key, $default = null);

    /**
     * Get many repository items.
     *
     * @param  array  $keys
     * @return array
     */
    abstract public function getMany(array $keys);

    /**
     * Set a given repository items.
     *
     * @param  array|string  $key
     * @param  mixed   $value
     * @return void
     */
    abstract public function set($key, $value = null);

    /**
     * Prepend a value onto an array repository item.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    abstract public function prepend($key, $value);

    /**
     * Push a value onto an array repository item.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    abstract public function push($key, $value);

    /**
     * Get all of the repositoru items.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }
}