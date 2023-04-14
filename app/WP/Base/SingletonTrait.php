<?php

namespace Brtled\WP\Base;

trait SingletonTrait
{
    protected static $instance;

    public static function setInstance($instance)
    {
        static::$instance = $instance;
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        return static::$instance ?? static::$instance = new static;
    }

    /**
     * @return static
     */
    public static function i()
    {
        return static::$instance;
    }
}