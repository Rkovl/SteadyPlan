<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/partials/defaultHead.php';
    ?>
    <link rel="stylesheet" href="/public/css/board-style.css">
    <title>Project Board</title>
</head>
<body class="d-flex flex-column min-vh-100">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>

<main class="d-flex flex-grow-1 flex-column">
    <div class="board">
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/controllers/board-columns.php';
        ?>
    </div>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php';
?>
<script src="js/tasks.js"></script>
</body>
</html>