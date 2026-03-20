<?php

$page = $_GET['view'] ?? 'home';

switch ($page) {
    case 'create':
        $content = '';
        break;

    case 'edit':
        $content = '';
        break;

    default:
        $content = 'view/Todo/home.php';
        break;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Todo App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <?php include 'view/partial/navbar.php'; ?>

    <div class="container">
        <?php
        if (isset($content)) {
            include $content;
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION['flash'])): ?>
        <script>
            Swal.fire({
                icon: "<?= $_SESSION['flash']['type'] ?>",
                title: "<?= $_SESSION['flash']['type'] === 'success' ? 'Success' : 'Error' ?>",
                text: "<?= $_SESSION['flash']['message'] ?>",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    <?php unset($_SESSION['flash']);
    endif; ?>
</body>

</html>