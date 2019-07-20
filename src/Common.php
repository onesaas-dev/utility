<?php

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

use OneSaas\Components\Container\Container;

if (!function_exists('get_container'))
{
	/**
	 * Retrieve the current Container Instance.
	 *
	 * @return Container
	 */
	function get_container()
	{
		return Container::getInstance() ?: new Container;
	}
}