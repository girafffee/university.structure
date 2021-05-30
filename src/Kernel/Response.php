<?php


namespace App\Kernel;

use App\Layouts\FooterLayoutPart;
use App\Layouts\HeaderLayoutPart;
use App\Layouts\HeadLayoutPart;
use App\Tools;


class Response {

	private $layout = US_LAYOUT;

	public $pageData = array(
		'head'    => '',
		'header'  => '',
		'content' => '',
		'footer'  => ''
	);

//*------------------------------------------------------------
// Собрать данные для построения страницы
	public function buildPageData() {
		$this->pageData['head']   = HeadLayoutPart::get()->getContent();
		$this->pageData['footer'] = FooterLayoutPart::get()->getContent();
		$this->pageData['header'] = HeaderLayoutPart::get()->getContent();
	}

	public function layout( string $tplName = '' ): string {
		if ( '' !== $tplName ) {
			$this->layout = $tplName;
		}

		return $this->layout;
	}

	public function renderPage() {
		ob_start();
		include Tools::getView( "layouts/{$this->layout()}.php" );

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
