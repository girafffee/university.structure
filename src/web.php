<?php

namespace App;

use App\Controllers\HomeController;
use App\Kernel\Router;

Router::add( '/', HomeController::class )
      ->name( 'home' );
