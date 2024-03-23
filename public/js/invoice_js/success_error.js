
    document.addEventListener('DOMContentLoaded', function () {
        // Show the overlay and alert
        document.getElementById('overlay').classList.add('show');
        document.getElementById('customAlert').classList.add('show');

        // Hide the overlay and alert after 1.5 seconds
        setTimeout(function () {
            document.getElementById('overlay').classList.remove('show');
            document.getElementById('customAlert').classList.remove('show');
        }, 1900);
    });
