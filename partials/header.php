<header class="bg-body-secondary border-bottom shadow-sm">
    <nav class="navbar navbar-expand-sm">
        <div class="container-fluid">

            <div class="d-flex align-items-center w-100">
                <a href="/" class="navbar-brand d-flex align-items-center gap-2 fw-bold me-auto">
                    <img src="/public/images/SteadyPlan_Logo.png" alt="Logo" width="40" height="40">
                    <span>Steady Plan</span>
                </a>

                <button id="themeToggleBtnMobile"
                        class="btn btn-light d-sm-none me-2 theme-button"
                        aria-label="Toggle Theme"
                        onclick="toggleTheme()">
                    <i class="bi bi-sun"></i>
                </button>
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
                                aria-label="Toggle Theme"
                                onclick="toggleTheme()">
                            <i class="bi bi-sun"></i>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-outline-secondary px-4">Login</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-primary px-4">Sign Up</button>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
</header>