<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';

// Get project ID from URL parameter
$projectID = $_GET['projectID'] ?? null;
if (!$projectID) {
    // Redirect to dashboard if no project ID is provided
    header('Location: /public/dashboard.php');
    exit();
}
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
        $_GET['projectID'] = $projectID;
        include $_SERVER['DOCUMENT_ROOT'] . '/controllers/board-columns.php';
        ?>
    </div>
</main>

<!-- Task Input Overlay -->
<div class="task-input-overlay" id="taskInputOverlay">
    <div class="task-input-modal">
        <label for="taskNameInput"><h3>Add New Task</h3></label>
        <input type="text" id="taskNameInput" placeholder="Enter task name..." />
        <div class="button-group">
            <button class="btn-cancel" id="cancelTaskBtn">Cancel</button>
            <button class="btn-create" id="createTaskBtn">Create</button>
        </div>
    </div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php';
?>
<script>
    // Make projectID available to JavaScript
    const PROJECT_ID = '<?php echo htmlspecialchars($projectID, ENT_QUOTES); ?>';
</script>
<script src="js/tasks.js"></script>
</body>
</html>