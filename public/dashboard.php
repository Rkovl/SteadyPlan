<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

//echo json_encode(['user' => $_SESSION['user_id'] ?? null]);

?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/partials/defaultHead.php';
    ?>
    <link rel="stylesheet" href="/public/css/dashboardStyle.css">
    <title>Project Board</title>
</head>
<body class="d-flex flex-column min-vh-100" data-user-id="<?= $_SESSION['user_id'] ?? '' ?>">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>

<div class="overlay justify-content-center align-items-center">
    <div class="card overlayDisplay">
        <button id="closeOverlay">x</button>
        <div class="card-body">
            <h5 class="card-title fw-bold">Update Project Data</h5>
            <div>
                <div class="mb-3">
                    <label for="nameChange" class="form-label">Project Name</label>
                    <input type="text" class="form-control" id="nameChange">
                </div>
                <button type="button" class="btn btn-primary mb-5">Change Name</button>
                <div class="mb-3">
                    <label for="addUser" class="form-label">Add User</label>
                    <input type="text" class="form-control" id="addUser">
                </div>
                <button type="button" class="btn btn-primary">Invite</button>
            </div>
        </div>
    </div>
</div>

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
                <input id="addProjectInput" type="text" class="form-control form-control-sm" placeholder="Add Project" style="width: 200px;">
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
                </thead>
                <tbody id="projectTableBody">
                    <!-- <tr>
                        <td>Project Alpha</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar ps-2 pe-2 pt-1 pb-1 me-2 rounded-5" style="background: linear-gradient(135deg, #667eea 0%, #a1c5e6ff 100%);">DL</div>
                                Devon Lane
                            </div>
                        </td>
                        <td>131</td>
                        <td>12</td>
                        <td>324</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Open</button>
                            <button class="btn btn-sm btn-outline-secondary">Edit</button>
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </td>
                    </tr>
                    More rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-body-secondary">
        <div class="text-muted small">
                    <!-- Showing 1 to 6 of 6 entries -->
        </div>
    </div>
</main>



<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php';
?>
<script defer src="/public/js/populateProjects.js"></script>
</body>
</html>