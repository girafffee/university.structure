<?php


namespace App\Layouts;


class HeadLayoutPart extends BaseLayoutPart {

	public function getContent(): string {
		return $this->render( 'layouts/head.php' );
	}

}