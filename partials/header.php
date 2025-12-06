<?php
/*
 * Site partial for navbar.
 */
$isLoggedIn = isLoggedIn();
//$isLoggedIn = true; //for testing purposes
?>
<header class="bg-body-secondary border-bottom shadow-sm">
    <nav class="navbar navbar-expand-sm">
        <div class="container-fluid">

            <div class="d-flex align-items-center w-100">
                <a href="index.php" class="navbar-brand d-flex align-items-center gap-2 fw-bold me-auto">
                    <img src="/public/images/logo.svg" alt="Logo" width="48" height="48" class="logo-svg">
                    <span class="fs-3">Steady Plan</span>
                </a>

                <button id="themeToggleBtnMobile"
                        class="btn btn-light d-sm-none me-2 theme-button"
                        aria-label="Toggle Theme">
                    <i class="bi bi-sun"></i>
                </button>
                <?php if ($isLoggedIn): ?>
                    <button id="settingsBtnMobile"
                            class="btn btn-light d-sm-none me-2 theme-reactive-btn"
                            aria-label="Toggle Theme" onclick="window.location.href='account.php'">
                        <i class="bi bi-gear"></i>
                    </button>

                    <?php if (isAdmin()): ?>
                        <button id="adminBtnMobile"
                                class="btn btn-light d-sm-none me-2 theme-reactive-btn"
                                aria-label="Toggle Theme" onclick="window.location.href='admin.php'">
                            <i class="bi bi-database-gear"></i>
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                        aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse w-100 mt-2 mt-sm-0" id="mainNav">
                <ul class="navbar-nav ms-auto flex-column flex-sm-row align-items-end gap-2">
                    <li class="d-none d-sm-inline-block">
                        <button id="themeToggleBtnDesktop"
                                class="btn btn-light theme-button"
                                aria-label="Toggle Theme">
                            <i class="bi bi-sun"></i>
                        </button>
                    </li>
                    <?php if ($isLoggedIn): ?>
                        <li class="d-none d-sm-inline-block">
                            <button id="settingsBtnDesktop"
                                    class="btn btn-light theme-reactive-btn"
                                    aria-label="Settings" onclick="window.location.href='account.php'">
                                <i class="bi bi-gear"></i>
                            </button>
                        </li>

                        <?php if (isAdmin()): ?>
                            <li class="d-none d-sm-inline-block">
                                <button id="adminBtnDesktop"
                                        class="btn btn-light theme-reactive-btn"
                                        aria-label="Toggle Theme" onclick="window.location.href='admin.php'">
                                    <i class="bi bi-database-gear"></i>
                                </button>
                            </li>
                        <?php endif; ?>

                        <li>
                            <button type="button" class="btn btn-outline-secondary px-4" id="dashboardBtn">Dashboard
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-primary px-4" id="logoutBtn">Logout</button>
                        </li>
                    <?php else: ?>
                        <li>
                            <button type="button" class="btn btn-outline-secondary px-4" id="loginBtn">Login</button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-primary px-4" id="signupBtn">Sign Up</button>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>