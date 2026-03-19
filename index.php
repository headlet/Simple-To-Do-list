<?php

$page = $_GET['view'] ?? 'home';

switch ($page) {
    case 'create':
        $content = 'view/Todo/create.php';
        break;

    case 'edit':
        $content = 'view/Todo/edit.php';
        break;

    default:
        $content = 'view/Todo/home.php';
        break;
}

include 'view/partial/master.php';