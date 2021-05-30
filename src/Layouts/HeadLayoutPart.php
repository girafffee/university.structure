<?php


namespace App\Layouts;

use App\InstanceTrait;

/**
 * @method static BaseLayoutPart get()
 *
 * Class HeadLayoutPart
 * @package App\Layouts
 */
class HeadLayoutPart extends BaseLayoutPart {

	use InstanceTrait;

	public function getContent(): string {
		HeadLayoutPart::get()->registerCss( 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css' );
		HeadLayoutPart::get()->registerJs( 'https://code.jquery.com/jquery-3.6.0.min.js', self::POS_HEAD );
		HeadLayoutPart::get()->registerJsVar( 'globalConfig', US_ALIASES );
		FooterLayoutPart::get()->registerJs( 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js' );

		return $this->render( 'layout-parts/head.php' );
	}

}