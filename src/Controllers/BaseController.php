<?php

namespace App\Controllers;

use App\Helpers\RenderTrait;
use App\Kernel\Router;

class BaseController {

	use RenderTrait;

	public function redirect( $nameRoute, $args = array() ) {
		$url = Router::route( $nameRoute, $args );
		//echo $url; die;
		header( "Location: " . $url );
		exit;
	}

	public function filterData( &$data ) {
		foreach ( $_POST as $key => $post ) {
			if ( is_string( $post ) ) {
				$data[ $key ] = htmlspecialchars( trim( $post ) );
				continue;
			}
			$data[ $key ] = $post;
		}
	}

}