<?php

namespace App\Composer\Core;


class Application
{
    private static $instance;


    public function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function run()
    {
        if (isset(static::$instance)) {
            (new Model\view)->widok();
        }
    }
}