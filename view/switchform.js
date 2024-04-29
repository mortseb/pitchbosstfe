document.getElementById('form-switch').addEventListener('change', function() {
    var loginForm = document.getElementById('login-form');
    var registerForm = document.getElementById('register-form');
    if (this.checked) {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    } else {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
    }
});
