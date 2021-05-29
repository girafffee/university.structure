<?php


namespace App\Kernel;


class Router {

	/**
	 * @var RouteItem[]
	 */
	public static $routes;

	public static function add( $url, $controller, $parent_id = null ): RouteItem {
		self::$routes[ $url ] = new RouteItem( $url, $controller, $parent_id );

		return self::$routes[ $url ];
	}

	static function addGroup( $url, $controller ): RouteItem {
		$url = strtolower( $url );
		$url = str_replace( '{', '', $url );
		$url = str_replace( '}', '', $url );
		$url = explode( '/', $url );


		array_shift( $url );
		$mainUrl = '/' . $url[0];

		$path = array();

		for ( $i = 1; $i < sizeof( $url ); $i ++ ) {
			$path[] = $url[ $i ];
		}

		$route = self::add( $mainUrl, $controller );
		$route->addPath( $path );

		return $route;
	}

	public static function route( $name, $args = array() ): string {
		foreach ( self::$routes as $route ) {
			if ( $route->name == $name || $route->url == $name ) {
				if ( empty( $args ) ) {
					return $route->url;
				}

				foreach ( $args as $key => $value ) {
					$route->addArg( $key, $value );
				}


				return self::buildUrl( $route );
			}
		}
	}

	private static function buildUrl( $route ): string {
		return $route->url . '/' . implode( '/', $route->arg );
	}

	public static function checkArgs( $name ): bool {
		return count( self::$routes[ $name ]->arg ) == count( self::$routes[ $name ]->path );
	}

	/*
	|--------------------------------------------------------------------------
	| Создание запрошенного контроллера
	|--------------------------------------------------------------------------
	|
	| Router создает выбранный пользователем контроллер через URL,
	| и передеает ему параметры
	|
	*/
	public function callController(): string {
		$url = explode( '?', $_SERVER['REQUEST_URI'] );
		$url = $url[0];

		if ( array_key_exists( $url, self::$routes ) or array_key_exists( substr( $url, 0, strlen( $url ) - 1 ), self::$routes ) ) {

			if ( ! isset( self::$routes[ $url ] ) ) {
				$url = substr( $url, 0, strlen( $url ) - 1 );
			}

			return $this->callControllerAction( $url, self::$routes[ $url ]->action );

		} else {
			// динамический маршрут с аргументами
			$url = explode( "/", $url );
			array_shift( $url );
			$mainUrl = '/' . $url[0];

			if ( isset( self::$routes[ $mainUrl ] ) ) {
				array_shift( $url );
				self::$routes[ $mainUrl ]->arg = $url;


				if ( self::checkArgs( $mainUrl ) ) {
					$action = self::$routes[ $mainUrl ]->action;

					if ( in_array( 'action', self::$routes[ $mainUrl ]->path ) ) {
						$action_key = array_search( 'action', self::$routes[ $mainUrl ]->path );
						$action     = self::$routes[ $mainUrl ]->arg[ $action_key ];
						unset( self::$routes[ $mainUrl ]->arg[ $action_key ] );
					}

					return $this->callControllerAction( $mainUrl, $action, self::$routes[ $mainUrl ]->arg );
				}
			}
		}
	}

	private function callControllerAction( $routeUrl, $action, $args = array() ) {
		$action = ucfirst( $action );
		$object = new self::$routes[ $routeUrl ]->controller();

		return call_user_func( array( $object, "action{$action}" ), $args );
	}


	private static $instance;

	public static function instance(): Router {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
	}

}