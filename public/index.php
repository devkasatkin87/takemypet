<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("__ROOT__", dirname(__FILE__,2));

require_once __ROOT__.'/vendor/autoload.php';

use src\System\App;

$app = App::getAppInstance();
$app->run();