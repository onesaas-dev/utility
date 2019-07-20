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

use Illuminate\Support\Facades\Validator;
use OneSaas\Components\Utility\Repository\ItemRepository;
use RuntimeException;
use OneSaas\Components\Container\Container;

abstract class Driver
{
	/**
	 * @var null
	 */
	public $name = null;
	/**
	 * @var null
	 */
	public $description = null;
	/**
	 * @var null
	 */
	public $author = null;
	/**
	 * @var null
	 */
	public $version = null;
	/**
	 * @var null
	 */
	public $copyright = null;
	
	/**
	 * @var array
	 */
	protected $config_items = [];
	/**
	 * @var array
	 */
	protected $dependencies = [];
	
	/**
	 * @var
	 */
	protected $config;
	/**
	 * @var \OneSaas\Components\Container\Container
	 */
	protected $container;
	
	/**
	 * Driver constructor.
	 *
	 * @param Container|null $container
	 * @param array          $config
	 */
	public function __construct(Container $container = null, array $config = [])
	{
		if ($this->checkDriverIntegrity($config))
		{
			$this->container = $container ?: get_container();
		}
	}
	
	/**
	 * @param array $config
	 *
	 * @return bool
	 */
	private function checkDriverIntegrity(array $config = [])
	{
		$valid = true;
		
		if (empty($this->name) && empty($this->description)
			&& empty($this->author)
			&& empty($this->version)
			&& empty($this->copyright)
		)
		{
			$valid = false;
		} elseif (!empty($this->config_items))
		{
			$valid = $this->validateConfig($config);
		} elseif (!empty($this->dependencies))
		{
			$valid = $this->checkDependencies();
		}
		
		if (false === $valid)
		{
			$driver_name = $this->name ?? __CLASS__;
			
			throw new RuntimeException(
				"Integrity check failed for driver [$driver_name]."
			);
		}
		
		return $valid;
	}
	
	public function validateConfig(array $config = [])
	{
		if (! empty($this->config_items))
		{
			// @todo: filter items.
		}
		
		if (! $this->config instanceof ItemRepository)
		{
			$this->config = new ItemRepository($config);
		}
		
		return true;
	}
}