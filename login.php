<?php
// Iniciar sesión
session_start();

 $_SESSION['error_username'] = $_SESSION['error_password']="";
// Manejar el inicio de sesión
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y sanear los campos.
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Validar el nombre de usuario.
    if (empty($username)) {
        $_SESSION['error_username'] = "El nombre de usuario es obligatorio.";
    }

    // Validar la contraseña.
    if (empty($password)) {
        $_SESSION['error_password'] = "La contraseña es obligatoria.";
    }

    // Redirigir a la misma página para mostrar los errores.
    if (isset($_SESSION['error_username']) || isset($_SESSION['error_password'])) {
        header("Location: index.php");
        exit();
    }

    // Aquí puedes agregar la lógica para autenticar al usuario
    // Si la autenticación falla, puedes establecer errores similares y redirigir
    // Si la autenticación es exitosa, redirigir a una página de éxito o dashboard
}

// Redirigir si accede a esta página sin POST
header("Location: index.php");
exit();
?>
