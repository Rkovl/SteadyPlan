/*
 * Handles user logout requests.
 */
function logOut() {
    // call logout api in backend
    fetch('/SteadyPlan/api/logout.php', {
        method: 'POST',
        credentials: 'include'
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // redirect to homepage after logout
                window.location.href = "/SteadyPlan/public/index.php";
            } else {
                alert('Logout failed: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error during logout:', error);
        });
}