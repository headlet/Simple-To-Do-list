<!DOCTYPE html>
<html>
<head>
    <title>Todo App</title>
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