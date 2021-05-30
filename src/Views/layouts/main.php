<?php
/**
 * @var Response $this
 */

use App\Kernel\Response;

?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->pageData['head'] ?>
</head>
<body>

<header class="main">
	<?= $this->pageData['header'] ?>
</header>

<section class="main mt-3">
	<?= $this->pageData['content'] ?>
</section>

<footer class="main">
	<?= $this->pageData['footer'] ?>
</footer>

</body>
</html>
