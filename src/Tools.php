<?php


namespace App;


class Tools {

	public static function getView( string $path ): string {
		return Config::VIEWS_PATH . "/$path";
	}

}