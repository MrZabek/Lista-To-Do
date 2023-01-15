<?php

namespace App\Composer\Core;

use App\Composer\Core\Model;

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

    public function connect()
    {
        if (isset(static::$instance)) {
            $pol = mysqli_connect('localhost', 'root', '', 'listatodo');
        }
        return $pol;
    }

    public function run()
    {
        if (isset(static::$instance)) {
            (new Model\view)->widok();
        }
    }
}