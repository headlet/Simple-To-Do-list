<?php

$page = $_GET['view'] ?? 'home';

switch ($page) {
    case 'create':
        $content = 'view/Todo/create.php';
        break;

    case 'store':
        $content = 'view/Todo/tore.php';
        break;

    default:
        $content = 'view/Todo/home.php';
        break;
}

include 'view/partial/master.php';