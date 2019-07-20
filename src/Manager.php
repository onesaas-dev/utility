<?php namespace OneSaas\Components\Utility;

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

use Closure;
use InvalidArgumentException;

abstract class Manager
{
	/**
	 * The registered custom driver loaders.
	 *
	 * @var array
	 */
	protected $loaders = [];
	
	/**
	 * The array of created "drivers".
	 *
	 * @var array
	 */
	protected $drivers = [];
	
	/**
	 * The Default Driver.
	 *
	 * @var string|null
	 */
	protected $default = null;
	
	public function __construct(array $config = [])
	{
		if (!empty($config))
		{
			if (isset($config['default']))
			{
				$this->default = $config['default'];
			}
			
			if (isset($config['loaders']))
			{
				if (!is_array($config['loaders']))
				{
					throw new InvalidArgumentException(
						"The Drivers provided to the " . __CLASS__ . "
                                                                    manager must be in array format."
					);
				}
				foreach ($config['loaders'] as $name => $loader)
				{
					$this->extend($name, $loader);
				}
			}
		}
	}
	
	/**
	 * Register a custom driver loader Closure.
	 *
	 * @param string  $driver
	 * @param Closure $callback
	 *
	 * @return $this
	 */
	public function extend($driver, Closure $callback)
	{
		$this->loaders[$driver] = $callback;
		
		return $this;
	}
	
	/**
	 * Get a Driver Instance.
	 *
	 * @param string $driver
	 *
	 * @return mixed
	 */
	public function driver(string $driver = null)
	{
		$driver = $driver ?: $this->getDefaultDriver();
		
		if (is_null($driver))
		{
			throw new InvalidArgumentException(
				sprintf(
					'Unable to resolve NULL driver for [%s].', static::class
				)
			);
		}
		
		// If the given driver has not been created before, we will create the instances
		// here and cache it so we can return it next time very quickly. If there is
		// already a driver created by this name, we'll just return that instance.
		if (!isset($this->drivers[$driver]))
		{
			$this->drivers[$driver] = $this->loadDriver($driver);
		}
		
		return $this->drivers[$driver];
	}
	
	/**
	 * Create a new Driver Instance,
	 * or retrieve one already created.
	 *
	 * @param string $driver
	 *
	 * @return mixed
	 */
	protected function loadDriver(string $driver)
	{
		if (isset($this->loaders[$driver]))
		{
			return $this->callLoader($driver);
		} else
		{
			$method = 'load' . Str::studly($driver) . 'Driver';
			
			if (method_exists($this, $method))
			{
				return $this->$method();
			}
		}
		
		throw new InvalidArgumentException("Driver [$driver] not supported.");
	}
	
	/**
	 * Get the default driver name.
	 *
	 * @return string
	 */
	public function getDefaultDriver()
	{
		return is_null($this->default) ?: $this->default;
	}
	
	/**
	 * Call upon a custom Driver Loader.
	 *
	 * @param string $driver
	 *
	 * @return mixed
	 */
	protected function callLoader(string $driver)
	{
		return $this->loaders[$driver]();
	}
	
	/**
	 * Get all of the created "drivers".
	 *
	 * @return array
	 */
	public function getDrivers()
	{
		return $this->drivers;
	}
	
	/**
	 * Dynamically call the default driver instance.
	 *
	 * @param string $method
	 * @param array  $parameters
	 *
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		return $this->driver()->$method(...$parameters);
	}
}