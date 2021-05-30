<?php


namespace App;


trait InstanceTrait {

	private static $instance;

	public static function get() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
	}

}