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
use Symfony\Component\VarDumper\VarDumper;

trait Dumpable
{
    /**
     * Dump the Class contents for visual inspection, this should
     * really only be used for debugging purposes.
     *
     * @return mixed
     */
    public function dump()
    {
        return VarDumper::dump($this);
    }
}