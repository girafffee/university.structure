<?php

use App\Tools;
use App\Kernel\Router;

function us_alias( string $raw_string ): string {
	return Tools::parse( $raw_string );
}

function us_route( string $name, array $args = array() ): string {
	return Router::route( $name, $args );
}
