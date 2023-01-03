<?php

use Masch\Getweekdays\Controllers\IndexController;
use Masch\Getweekdays\Controllers\UploadController;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$frontController = new IndexController();
$frontController->handleRequest();

