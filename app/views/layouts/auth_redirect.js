// Prevent access to login page when already logged in
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on login page and user is logged in
    if (window.location.href.includes('login') || window.location.href.includes('register')) {
        // Check if user is logged in (you can modify this check based on your session handling)
        fetch('index.php?url=api/check-auth')
            .then(response => response.json())
            .then(data => {
                if (data.loggedIn) {
                    // Redirect to dashboard if already logged in
                    window.location.href = 'index.php?url=dashboard';
                }
            })
            .catch(error => {
                console.log('Auth check failed:', error);
            });
    }
});

// Handle browser back button
window.addEventListener('popstate', function(event) {
    // If user tries to go back to login page while logged in, redirect to dashboard
    if (window.location.href.includes('login') || window.location.href.includes('register')) {
        fetch('index.php?url=api/check-auth')
            .then(response => response.json())
            .then(data => {
                if (data.loggedIn) {
                    window.location.href = 'index.php?url=dashboard';
                }
            })
            .catch(error => {
                console.log('Auth check failed:', error);
            });
    }
});
