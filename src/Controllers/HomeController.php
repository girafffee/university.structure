<?php


namespace App\Controllers;


class HomeController extends BaseController {

	public function actionIndex(): string {
		return $this->render( 'home.tpl.php' );
	}

}