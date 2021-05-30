<?php

namespace App;

use App\Kernel\Response;
use App\Kernel\Router;

require_once 'config.php';
require_once 'web.php';
require_once 'functions.php';

$response = Response::instance();
$response->append(
	'content', Router::instance()->callController()
);

$response->buildPageData();

echo $response->renderPage();
