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

use ArrayAccess;
use OneSaas\Components\Utility\Arr;

class ItemRepository extends AbstractRepository implements ArrayAccess
{
	/**
	 * Determine if the given repository item exists.
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has($key)
	{
		return Arr::has($this->items, $key);
	}
	
	/**
	 * Get the specified repository item.
	 *
	 * @param array|string $key
	 * @param mixed        $default
	 *
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		if (is_array($key))
		{
			return $this->getMany($key);
		}
		
		return Arr::get($this->items, $key, $default);
	}
	
	/**
	 * Get many configuration values.
	 *
	 * @param array $keys
	 *
	 * @return array
	 */
	public function getMany(array $keys)
	{
		$config = [];
		
		foreach ($keys as $key => $default)
		{
			if (is_numeric($key))
			{
				[$key, $default] = [$default, null];
			}
			
			$config[$key] = Arr::get($this->items, $key, $default);
		}
		
		return $config;
	}
	
	/**
	 * Set a given repository items.
	 *
	 * @param array|string $key
	 * @param mixed        $value
	 *
	 * @return void
	 */
	public function set($key, $value = null)
	{
		$keys = is_array($key) ? $key : [$key => $value];
		
		foreach ($keys as $key => $value)
		{
			Arr::set($this->items, $key, $value);
		}
	}
	
	/**
	 * Prepend a value onto an array repository item.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function prepend($key, $value)
	{
		$array = $this->get($key);
		
		array_unshift($array, $value);
		
		$this->set($key, $array);
	}
	
	/**
	 * Push a value onto an array repository item.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function push($key, $value)
	{
		$array = $this->get($key);
		
		$array[] = $value;
		
		$this->set($key, $array);
	}
	
	/**
	 * Determine if the given configuration option exists.
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return $this->has($key);
	}
	
	/**
	 * Get a configuration option.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->get($key);
	}
	
	/**
	 * Set a configuration option.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function offsetSet($key, $value)
	{
		$this->set($key, $value);
	}
	
	/**
	 * Unset a configuration option.
	 *
	 * @param string $key
	 *
	 * @return void
	 */
	public function offsetUnset($key)
	{
		$this->set($key, null);
	}
}