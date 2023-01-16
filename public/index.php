<?php

include_once __DIR__ . "/../vendor/autoload.php";

use App\Composer\Core\Application;

$app = (new Application)->getInstance();
$app->run();
