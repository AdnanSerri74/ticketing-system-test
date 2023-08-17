<?php

use app\Core\App;
use app\Core\Container;
use app\Core\DB;

$container = new Container();

$container->bind('app\Core\DB', fn() => new DB);

App::setContainer($container);
