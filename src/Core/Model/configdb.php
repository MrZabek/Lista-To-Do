<?php

namespace App\Composer\Core\Model;

class configdb
{
    public static function pol()
    {
        $poloczenie = mysqli_connect("localhost", "root", "", "listatodo");
        return $poloczenie;
    }

    public function close()
    {
        if (isset($poloczenie)) {
            mysqli_close($poloczenie);
        }
    }
}