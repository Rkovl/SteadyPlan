<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/ProjectRepo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['user_id'];

$projects = ProjectRepo::getAllProjects($userID);
if (!$projects) {
    $projects = [];
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

<main class="card text-center m-5 shadow">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="true" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <div class="d-flex gap-2">
                <input id="searchBar" type="search" class="form-control form-control-sm" placeholder="Search..." style="width: 200px;">
                <button id="addProject" class="btn btn-primary btn-sm">Add Project</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Created By</th>
                    <th># of Users</th>
                    <th># of Columns</th>
                    <th># of Tasks</th>
                    <th>Actions</th>
                </tr>
                <tbody id="projectTableBody">
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?= htmlspecialchars($project['project_name']) ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar ps-2 pe-2 pt-1 pb-1 me-2 rounded-5" style="background: linear-gradient(135deg, #667eea 0%, #a1c5e6ff 100%);">
                                    <?= strtoupper($project['owner_username'][0]) ?>
                                </div>
                                <?= htmlspecialchars($project['owner_username']) ?>
                            </div>
                        </td>
                        <td><?= $project['num_members'] ?></td>
                        <td><?= $project['num_columns'] ?></td>
                        <td><?= $project['num_tasks'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary openButton">Open</button>
                            <button class="btn btn-sm btn-outline-success editButton">Edit</button>
                            <button class="btn btn-sm btn-outline-danger deleteButton">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-body-secondary">
        <div class="text-muted small">
            Showing 1 to 6 of 6 entries
        </div>
    </div>
</main>



<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php';
?>
<script defer src="/public/js/populateProjects.js"></script>
</body>
</html>