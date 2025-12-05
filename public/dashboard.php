<?php
require_once __DIR__ . '/../db/auth.php';
// require_once (__DIR__ . "/../repos/columnRepo.php");
// // if(!isLoggedIn()){
// //     header('Location: index.php');
// //     exit();
// // }

// function getProject($userID){
//     $projects = ProjectUserRepo::getUserProjects($userID);

//     if ($projects) {
//         foreach ($projects as $project) {
//             addColumn($project['id'], $project['name']);
//         }
//     } else {
//         initializeDefaultBoard();
//     }
// }

// getProject("ed11542d-d816-443e-80f9-e5cb52f21e44");
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <?php
    include __DIR__ . '/../partials/defaultHead.php';
    ?>
    <link rel="stylesheet" href="/public/css/board-style.css">
    <title>Project Board</title>
</head>
<body class="d-flex flex-column min-vh-100">
<?php
include __DIR__ . '/../partials/header.php';
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
                <input type="search" class="form-control form-control-sm" placeholder="Search..." style="width: 200px;">
                <button class="btn btn-primary btn-sm">Add Project</button>
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
                        <th>Created Date</th>
                        <th># of Users</th>
                        <th># of Columns</th>
                        <th># of Tasks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Project Alpha</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar ps-2 pe-2 pt-1 pb-1 me-2 rounded-5" style="background: linear-gradient(135deg, #667eea 0%, #a1c5e6ff 100%);">DL</div>
                                Devon Lane
                            </div>
                        </td>
                        <td>2024-06-01</td>
                        <td>131</td>
                        <td>12</td>
                        <td>324</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success">Edit</button>
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </td>
                    </tr>
                    <!-- More rows as needed -->
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
include __DIR__ . '/../partials/footer.php';
?>
<script src="../js/tasks.js"></script>
</body>
</html>