<?php


namespace App\Helpers;


use App\Tools;

trait RenderTrait {

	/**
	 * Название шаблона
	 *
	 * @param $tplName
	 *
	 * Передаваемые параметры (переменные) в шаблон
	 * @param string $data
	 *
	 * FALSE    - полученный контенст сразу выводится на экран
	 * TRUE     - получанный контент становится возвращаемым значением типа string
	 * @param bool $output
	 *
	 * @return false|string|null
	 */
	public function render( $tplName, $data = array(), $output = true ): ?string {
		if ( empty( $tplName ) || $tplName == '' ) {
			return null;
		}

		if ( ! empty( $data ) ) {
			extract( $data );
		}

		// включаем буфер
		ob_start();

		include Tools::getView( $tplName );

		// сохраняем всё что есть в буфере в переменную $content
		$content = ob_get_clean();

		if ( $output ) {
			return $content;
		} else {
			echo $content;
		}
	}

	public function renderPartial( $tplName, $data = array() ) {
		if ( empty( $tplName ) || $tplName == '' ) {
			return null;
		}

		if ( ! empty( $data ) ) {
			extract( $data );
		}

		include Tools::getView( $tplName );
		exit();
	}

}