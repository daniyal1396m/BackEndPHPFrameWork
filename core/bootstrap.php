<?php

use Core\App;
use Core\database\Connection;
use Core\database\QueryBuilder;

require 'vendor/autoload.php';
require 'app/Helpers/functions.php';

App::bind('DB', new QueryBuilder(Connection::make()));
