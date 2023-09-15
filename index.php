<?php

use Core\Request;
use Core\Router;

header('Content-type: application/json');
header("Access-Control-Allow-Headers: Content-Type");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require 'core/bootstrap.php';


Router::load('app/Routes/routes.php')
    ->direct(Request::uri(), Request::method());
