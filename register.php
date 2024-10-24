<?php
// Iniciar sesión
session_start();
$_SESSION['error_nombre'] = "";
// Manejar el registro
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y sanear los campos.
    $nombre_registro = htmlspecialchars(trim($_POST['nombre_registro']));
    $nick_registro = htmlspecialchars(trim($_POST['nick_registro']));
    $email_registro = htmlspecialchars(trim($_POST['email_registro']));
    $password_register = htmlspecialchars($_POST['password_register']);
    $repetir_password = htmlspecialchars($_POST['repetir_password']);

    // Validar el nombre.
    if (empty($nombre_registro)) {
        $_SESSION['error_nombre'] = "El nombre es obligatorio.";
    } elseif (!preg_match("/^[A-Za-z\s]+$/", $nombre_registro)) {
        $_SESSION['error_nombre'] = "El nombre solo puede contener letras.";
    } else {
        $_SESSION['nombre_registro'] = $nombre_registro;
    }

    // Validar el nick.
    if (empty($nick_registro)) {
        $_SESSION['error_nick'] = "El nick es obligatorio.";
    }

    // Validar el correo electrónico.
    if (empty($email_registro)) {
        $_SESSION['error_email'] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email_registro, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_email'] = "El correo electrónico no es válido.";
    }

    // Validar la contraseña.
    if (empty($password_register)) {
        $_SESSION['error_password'] = "La contraseña es obligatoria.";
    } elseif (strlen($password_register) < 6) {
        $_SESSION['error_password'] = "La contraseña debe tener al menos 6 caracteres.";
    }

    // Validar la repetición de la contraseña.
    if ($password_register !== $repetir_password) {
        $_SESSION['error_repetir_password'] = "Las contraseñas no coinciden.";
    }

    // Redirigir a la misma página para mostrar los errores.
    if (isset($_SESSION['error_nombre']) || isset($_SESSION['error_nick']) || isset($_SESSION['error_email']) || isset($_SESSION['error_password']) || isset($_SESSION['error_repetir_password'])) {
        header("Location: index.php");
        exit();
    }

    // Aquí puedes agregar la lógica para registrar al usuario
    // Si el registro es exitoso, redirigir a una página de éxito o login
}

// Redirigir si accede a esta página sin POST
header("Location: index.php");
exit();
?>
