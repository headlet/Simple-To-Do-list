<!DOCTYPE html>
<html>

<head>
    <title>Todo App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <?php
        if (isset($content)) {
            include $content;
        }
        ?>
    </div>

</body>

</html>