<?php


namespace App\Kernel;

use App\Config;
use App\Layouts\HeadLayoutPart;
use App\Tools;


class Response {

	public $pageData = array(
		'head'    => '',
		'header'  => '',
		'content' => '',
		'footer'  => ''
	);

//*------------------------------------------------------------
// Собрать данные для построения страницы
	public function buildPageData() {
		$this->pageData['head']= HeadLayoutPart::get()->getContent();
	}

	public function renderPage() {
		$layoutName = Config::LAYOUT;

		ob_start();
		include Tools::getView( "layouts/{$layoutName}.php" );

		return ob_get_clean();
	}

	public function append( string $name, string $content ) {
		$this->pageData[ $name ] .= $content;
	}

	public function prepend( string $name, string $content ) {
		$this->pageData[ $name ] = $content . $this->pageData[ $name ];
	}


	private static $instance;

	public static function instance(): Response {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
	}

}
