<?php


namespace App;


class Tools {

	public static function getView( string $path ): string {
		return US_VIEWS_PATH . "/$path";
	}

	public static function parse( string $path ): string {
		return preg_replace_callback( '/%(.*?)%/i', function ( $matches ) {
			foreach ( US_ALIASES as $name => $value ) {
				if ( $name === $matches[1] ) {
					return $value;
				}
			}
			return $matches[1];
		}, $path );
	}

}