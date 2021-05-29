<?php


namespace App\Layouts;


use App\Helpers\RenderTrait;

abstract class BaseLayoutPart {

	use RenderTrait;

	abstract public function getContent() : string;

	private static $instance;

	public static function get(): BaseLayoutPart {
		if ( ! self::$instance ) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	private function __construct() {
	}

}