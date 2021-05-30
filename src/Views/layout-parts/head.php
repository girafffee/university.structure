<?php
/**
 * @var BaseLayoutPart $this
 */

use App\Layouts\BaseLayoutPart;

?>
<meta charset="utf-8">
<title><?= us_alias( '%site_name%' ) ?></title>
<?= $this->renderCss( BaseLayoutPart::POS_HEAD ); ?>
<?= $this->renderJsVars(); ?>
<?= $this->renderJs( BaseLayoutPart::POS_HEAD ) ?>
