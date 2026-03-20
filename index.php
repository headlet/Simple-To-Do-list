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
    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                let url = this.href;

                Swal.fire({
                    title: "Are you sure?",
                    text: "This task will be deleted permanently!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ef4444",
                    cancelButtonColor: "#3b82f6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

    <?php if (isset($_SESSION['flash'])): ?>
        <script>
            Swal.fire({
                icon: "<?= $_SESSION['flash']['type'] ?>",
                title: "<?= $_SESSION['flash']['type'] === 'success' ? 'Success' : 'Error' ?>",
                text: "<?= $_SESSION['flash']['message'] ?>",
            });
        </script>
    <?php unset($_SESSION['flash']);
    endif; ?>
</body>

</html>