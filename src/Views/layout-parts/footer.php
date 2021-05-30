<?php
/**
 * @var BaseLayoutPart $this
 */

use App\Layouts\BaseLayoutPart;

?>
<?= $this->renderCss( BaseLayoutPart::POS_BODY ); ?>
<?= $this->renderJs( BaseLayoutPart::POS_BODY ) ?>
