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
use RuntimeException;

abstract class Driver
{
    public $name            = null;
    public $description     = null;
    public $author          = null;
    public $version         = null;
    public $copyright       = null;

    protected $config_items = [];
    protected $dependencies = [];

    protected $config;
    protected $container;

    public function __construct(Container $container = null, $config = null)
    {
        if ($this->checkDriverIntegrity($config))
        {
            $this->container = $container ?: get_container();
        }
    }

    private function checkDriverIntegrity($config = null)
    {
        $valid = true;

        if (empty($this->name) &&
            empty($this->description) &&
            empty($this->author) &&
            empty($this->version) &&
            empty($this->copyright))
        {
            $valid = false;
        }
        elseif (! empty($this->config_items))
        {
            $valid = $this->validateConfig($config);
        }
        elseif (! empty($this->dependencies))
        {
            $valid = $this->checkDependencies();
        }

        if (false === $valid)
        {
            $driver_name = $this->name ?? __CLASS__;

            throw new RuntimeException("Integrity check failed for driver [$driver_name].");
        }

        return $valid;
    }
}