<?php
/**
 * @var BaseLayoutPart $this
 */

use App\Layouts\BaseLayoutPart;

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="<?= us_alias( '%root%' ) ?>">
			<?= us_alias( '%site_name%' ) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Розклад
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= us_route( 'schedule.student' ) ?>">Студента</a></li>
                        <li><a class="dropdown-item" href="">Академ. группи</a></li>
                        <li><a class="dropdown-item" href="">Викладача</a></li>
                        <li><a class="dropdown-item" href=""">Кафедри</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Списки
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= us_route( 'lists.student' ) ?>">Студентів</a></li>
                        <li><a class="dropdown-item" href="">Академ. групп</a></li>
                        <li><a class="dropdown-item" href="">Викладачів</a></li>
                        <li><a class="dropdown-item" href=""">Кафедр</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
