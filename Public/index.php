<?php

include_once __DIR__."/../vendor/autoload.php";
$app = (new App\Composer\Core\Application)->getInstance();
$app->run();

