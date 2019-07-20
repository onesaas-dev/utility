<?php namespace OneSaas\Components\Utility\Traits;

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
trait ContainerAware
{
	/**
	 * @return \OneSaas\Components\Container\Container
	 */
	public function container()
	{
		return get_container();
	}
}