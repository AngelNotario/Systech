    document.querySelector('#loginForm').addEventListener('submit', async (event) => {
        event.preventDefault();
        const usuario = document.querySelector('#usuario').value;
        const contraseña = document.querySelector('#password').value;
        console.log(usuario, contraseña);
        const response = await fetch("../controllers/validar.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `usuario=${usuario}&contraseña=${contraseña}`
        });
        const data = await response.json();
        if (data.success) {
            window.location.href = '../vistas/'+ data.redirect;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Usuario o contraseña incorrectos',
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#contraseña');
        const toggleIcon = document.querySelector('#toggleIcon');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the icon
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });
    });