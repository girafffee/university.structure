<?php


namespace App\Kernel;


class RouteItem {

	public $url;
	public $controller;
	public $action;
	public $name;
	public $arg;
	public $path;

	public $parent_id;  //url for parent route

	public function __construct( $url, $controller, $parent_id = null ) {
		$this->url        = $url;
		$this->controller = $controller;
		$this->setAction();
		$this->parent_id = $parent_id;
	}


	private function setAction() {
		$methods          = explode( '#', $this->controller );
		$this->controller = $methods[0];

		if ( count( $methods ) == 2 ) {
			$this->action = $methods[1];
		} else {
			$this->action = US_DEFAULT_ACTION;
		}
	}

	public function addArg( $key, $value ): RouteItem {
		$this->arg[ $key ] = $value;

		return $this;
	}

	public function addPath( $path ): RouteItem {
		$this->path = $path;

		return $this;
	}


	public function name( $name ): RouteItem {
		$this->name = $name;

		return $this;
	}

}