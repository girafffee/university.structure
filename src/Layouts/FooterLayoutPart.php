<?php


namespace App\Layouts;

use App\InstanceTrait;

/**
 * @method static BaseLayoutPart get()
 *
 * Class FooterLayoutPart
 * @package App\Layouts
 */
class FooterLayoutPart extends BaseLayoutPart {

	use InstanceTrait;

	public function getContent(): string {
		return $this->render( 'layout-parts/footer.php' );
	}

}