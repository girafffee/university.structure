<?php

namespace App;

use App\Controllers\HomeController;
use App\Controllers\StudentListController;
use App\Controllers\StudentScheduleController;
use App\Kernel\Router;

Router::add( '/', HomeController::class )
      ->name( 'home' );

Router::add( '/schedule/student', StudentScheduleController::class )
      ->name( 'schedule.student' );

Router::addGroup( '/schedule/student/{action}/{id}', StudentScheduleController::class )
      ->name( 'schedule.student.group' );

Router::add( '/lists/student', StudentListController::class )
      ->name( 'lists.student' );
