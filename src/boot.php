<?php

namespace App;

use App\Kernel\Response;
use App\Kernel\Router;

require_once 'web.php';

$response = Response::instance();
$response->append(
	'content', Router::instance()->callController()
);

$response->buildPageData();

echo $response->renderPage();
