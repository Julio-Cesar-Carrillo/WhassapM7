<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión y Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form-container text-center">
        <!-- Formulario de Inicio de Sesión -->
        <img src="./logo (2).png" alt="Iniciar Sesión" style="width: 100px; height: 100px; vertical-align: middle; margin-right: 20px;">

        <h2>Iniciar Sesión</h2>
        <form method="POST" action="login.php">
            <div class="mb-3">

                <input type="text" name="username" class="form-control" placeholder="Nombre de Usuario" value="darckfer">
                <span class="text-danger"><?php echo isset($_SESSION['error_username']) ? $_SESSION['error_username'] : ''; ?></span>

            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" value="qweQWE123">
                <span class="text-danger"><?php echo isset($_SESSION['error_password']) ? $_SESSION['error_password'] : ''; ?></span>
                <span class="text-danger"><?php echo isset($_SESSION['user_noexiste']) ? $_SESSION['user_noexiste'] : ''; ?></span>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label text-white" for="rememberMe">Recuérdame</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            <div class="text-center mt-2">
                <a href="#" class="text-white">¿Olvidaste tu contraseña?</a>
            </div>
        </form>

        <!-- Cambio a Registro -->
        <div class="form-switch mt-3">
            <p>¿No tienes una cuenta? <br> <a href="#" class="text-white" onclick="toggleForm()">Regístrate aquí</a></p>
        </div>
    </div>

    <div class="form-container d-none" id="registerForm">
        <!-- Formulario de Registro -->
        <h2>Registrarse</h2>
        <form method="POST" action="register.php">
            <div class="mb-3">
                <input type="text" name="nombre_registro" class="form-control" placeholder="Nombre">
                <span class="text-danger"><?php echo isset($_SESSION['error_nombre']) ? $_SESSION['error_nombre'] : ''; ?></span>

            </div>
            <div class="mb-3">
                <input type="text" name="nick_registro" class="form-control" placeholder="Nick">
                <span class="text-danger"><?php echo isset($_SESSION['error_nick']) ? $_SESSION['error_nick'] : ''; ?></span>

            </div>
            <div class="mb-3">
                <input type="email" name="email_registro" class="form-control" placeholder="Correo Electrónico">
                <span class="text-danger"><?php echo isset($_SESSION['error_email']) ? $_SESSION['error_email'] : ''; ?></span>

            </div>
            <div class="mb-3">
                <input type="password" name="password_register" class="form-control" placeholder="Contraseña">
                <span class="text-danger"><?php echo isset($_SESSION['error_password']) ? $_SESSION['error_password'] : ''; ?></span>

            </div>
            <div class="mb-3">
                <input type="password" name="repetir_password" class="form-control" placeholder="Repetir Contraseña">
                <span class="text-danger"><?php echo isset($_SESSION['error_repetir_password']) ? $_SESSION['error_repetir_password'] : ''; ?></span>

            </div>
            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>

        <!-- Cambio a Inicio de Sesión -->
        <div class="form-switch mt-3">
            <p>¿Ya tienes una cuenta? <a href="#" class="text-white" onclick="toggleForm()">Inicia Sesión aquí</a></p>
        </div>
    </div>

    <script>
        function toggleForm() {
            document.querySelector('.form-container').classList.toggle('d-none');
            document.getElementById('registerForm').classList.toggle('d-none');
        }
    </script>
</body>

</html>