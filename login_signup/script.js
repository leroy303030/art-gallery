document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault();
    const form = this;
    const username = form.querySelector('#username').value;
    const password = form.querySelector('#password').value;

    // Send a POST request to the server for authentication
    fetch('login.php', {
        method: 'POST',
        body: new FormData(form),
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            alert('Login successful!'); // Redirect or perform desired action on success.
        } else {
            alert('Login failed. Please check your credentials.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
