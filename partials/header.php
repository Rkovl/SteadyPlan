<?php
    require_once __DIR__.'/../db/auth.php';
    $isLoggedIn = isLoggedIn();
    //$isLoggedIn = true; //for testing purposes
?>
<header class="navbar navbar-expand-md sticky-top mb-4 ">
    <nav class="container border-bottom">
        <div class="col-md-3 mb-2 mb-md-0 col-6">
            <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none align-items-center fw-bold">
                <img src="./images/SteadyPlan_Logo.png" alt="Logo" class="bi me-2" width="40" height="40">
                Steady Plan
            </a>
        </div>
<?php if ($isLoggedIn): ?>
        <div class="col-md-4 text-end">
            <button type="button" class="btn btn-outline-primary me-2">Dashboard</button>
            <button type="button" class="btn btn-primary">Logout</button>
        </div>

<?php else: ?>
        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-outline-primary me-2">Login</button>
            <button type="button" class="btn btn-primary">Sign-up</button>
        </div>
<?php endif; ?>
    </nav>
</header>