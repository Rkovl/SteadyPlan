$(document).ready(function() {
    // Handle login button click
    $('#loginBtn').on('click', () => {
        window.location.href = "/SteadyPlan/db/login.php";
    });

    // Handle logout button click
    $('#logoutBtn').on('click', () => {
        logOut();
    });

    // Handle signup button click
    $('#signupBtn').on('click', () => {
        window.location.href = "/SteadyPlan/db/register.php";
    });
});

function logOut() {
    // call logout api in backend
    fetch('/SteadyPlan/controllers/UserController.php', {
        method: 'POST',
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // redirect to homepage after logout
            window.location.href = "/SteadyPlan/index.php";
        } else {
            alert('Logout failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error during logout:', error);
    });
}