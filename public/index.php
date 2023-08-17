<?php

const BASE_PATH = __DIR__ . '/../';

session_start();

require BASE_PATH . 'app/Core/functions.php';

require BASE_PATH. 'PHPMailer/src/Exception.php';
require BASE_PATH. 'PHPMailer/src/PHPMailer.php';
require BASE_PATH. 'PHPMailer/src/SMTP.php';

registerClasses();

require base_path('bootstrap.php');

$router = registerRoutes();

$routeInfo = identifyCurrentRouteInfo();

handleRequest($router, $routeInfo);




