$(document).ready(function() {
    // Handle login button click
    $('#loginBtn').on('click', () => {
        window.location.href = "/SteadyPlan/public/login.php";
    });

    // Handle logout button click
    $('#logoutBtn').on('click', () => {
        logOut();
    });

    $('#dashboardBtn').on ('click', () => {
        window.location.href = "/SteadyPlan/public/dashboard.php";
    });

    // Handle signup button click
    $('#signupBtn').on('click', () => {
        window.location.href = "/SteadyPlan/public/register.php";
    });
});