<?php


namespace App\Layouts;

use App\InstanceTrait;

/**
 * @method static BaseLayoutPart get()
 *
 * Class HeadLayoutPart
 * @package App\Layouts
 */
class HeaderLayoutPart extends BaseLayoutPart {

	use InstanceTrait;

	public function getContent(): string {
		return $this->render( 'layout-parts/header.php' );
	}

}