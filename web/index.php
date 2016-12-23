<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

require_once('../src/core/Autoloader.php');

//use core\Application;
//$app = Application::getInstance();

$app = core\Application::getInstance();

$app->run();