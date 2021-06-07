<?php


namespace App\Layouts;


use App\Helpers\RenderTrait;
use App\Tools;

abstract class BaseLayoutPart {

	use RenderTrait;

	protected $cssItems = array();
	protected $jsItems = array();
	protected $jsVars = array();

	const POS_HEAD = 'head';
	const POS_BODY = 'body';

	abstract public function getContent(): string;

	public function registerCss( string $url, string $position = self::POS_HEAD ): BaseLayoutPart {
		if ( ! isset( $this->cssItems[ $position ] ) ) {
			$this->cssItems[ $position ] = array();
		}
		$this->cssItems[ $position ][] = $url;

		return $this;
	}

	public function registerJs( string $url, string $position = self::POS_BODY ): BaseLayoutPart {
		if ( ! isset( $this->jsItems[ $position ] ) ) {
			$this->jsItems[ $position ] = array();
		}
		$this->jsItems[ $position ][] = $url;

		return $this;
	}

	public function registerJsVar( string $name, array $data, bool $safe = false ) {
		if ( $safe && isset( $this->jsVars[ $name ] ) ) {
			$data = array_merge( $this->jsVars[ $name ], $data );
		}
		$this->jsVars[ $name ] = $data;
	}

	public function renderCss( string $position ): string {
		$response = '';

		if ( ! isset( $this->cssItems[ $position ] ) ) {
			return $response;
		}
		foreach ( $this->cssItems[ $position ] as $href ) {
			$href = Tools::parse( $href );

			$response .= "<link rel=\"stylesheet\" href=\"$href\" />\n";
		}

		return $response;
	}

	public function renderJs( string $position ): string {
		$response = '';

		if ( ! isset( $this->jsItems[ $position ] ) ) {
			return $response;
		}
		foreach ( $this->jsItems[ $position ] as $href ) {
			$href = Tools::parse( $href );

			$response .= "<script src=\"$href\"></script>\n";
		}

		return $response;
	}

	public function renderJsVars(): string {
		if ( empty( $this->jsVars ) ) {
			return '';
		}

		$response = '<script>';
		foreach ( $this->jsVars as $js_var => $value ) {
			$value    = json_encode( $value, JSON_INVALID_UTF8_IGNORE );
			$response .= "window.$js_var = $value;" . "\n";
		}

		return ( $response . '</script>' );
	}

}