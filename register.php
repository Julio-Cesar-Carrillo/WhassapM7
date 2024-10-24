<?php
// Iniciar sesión
session_start();
$_SESSION['frnreegister'] = 'si';
// Inicializar variables de error en blanco
$_SESSION['error_nombre'] = $_SESSION['error_nick'] = $_SESSION['error_email'] = $_SESSION['error_password'] = $_SESSION['error_repetir_password'] = "";

// Manejar el registro
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y sanear los campos.
    $nombre_registro = htmlspecialchars(trim($_POST['nombre_registro']));
    $nick_registro = htmlspecialchars(trim($_POST['nick_registro']));
    $email_registro = htmlspecialchars(trim($_POST['email_registro']));
    $password_register = htmlspecialchars($_POST['password_register']);
    $repetir_password = htmlspecialchars($_POST['repetir_password']);
    
    $errores = false; // Bandera para controlar si hay errores

    // Validar el nombre.
    if (empty($nombre_registro)) {
        $_SESSION['error_nombre'] = "El nombre es obligatorio.";
        $errores = true;
    } elseif (!preg_match("/^[A-Za-z\s]+$/", $nombre_registro)) {
        $_SESSION['error_nombre'] = "El nombre solo puede contener letras.";
        $errores = true;
    } else {
        $_SESSION['nombre_registro'] = $nombre_registro;
    }

    // Validar el nick.
    if (empty($nick_registro)) {
        $_SESSION['error_nick'] = "El nick es obligatorio.";
        $errores = true;
    } elseif (!preg_match("/^[A-Za-z0-9_]+$/", $nick_registro)) {
        $_SESSION['error_nick'] = "El nick solo puede contener letras, números y guiones bajos.";
        $errores = true;
    }

    // Validar el correo electrónico.
    if (empty($email_registro)) {
        $_SESSION['error_email'] = "El correo electrónico es obligatorio.";
        $errores = true;
    } elseif (!filter_var($email_registro, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_email'] = "El correo electrónico no es válido.";
        $errores = true;
    }

    // Validar la contraseña.
    if (empty($password_register)) {
        $_SESSION['error_password'] = "La contraseña es obligatoria.";
        $errores = true;
    } elseif (strlen($password_register) < 6) {
        $_SESSION['error_password'] = "La contraseña debe tener al menos 6 caracteres.";
        $errores = true;
    }

    // Validar la repetición de la contraseña.
    if ($password_register !== $repetir_password) {
        $_SESSION['error_repetir_password'] = "Las contraseñas no coinciden.";
        $errores = true;
    }

    // Redirigir a la misma página para mostrar los errores si los hay.
    if ($errores) {
        header("Location: index.php");
        exit();
    }

    // Si no hay errores, proceder a insertar el usuario en la base de datos
    try {
        include "./conexion.php";
        
        // Cifrar la contraseña antes de guardarla
        $password_hashed = password_hash($password_register, PASSWORD_DEFAULT);
        
        // Preparar la consulta SQL
        $sql = "INSERT INTO tbl_usuarios (nom_usu, nick_usu, email_usu, pwd_usu) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($con);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $nombre_registro, $nick_registro, $email_registro, $password_hashed);
            mysqli_stmt_execute($stmt);

            // Cerrar la conexión
            mysqli_stmt_close($stmt);
            mysqli_close($con);
            // Deshacer los cambios en caso de error

            // Redirigir al login o a una página de éxito
            header("Location: login.php");
            echo "correcto";
            exit();
        } else {

            throw new Exception("Error al preparar la consulta SQL.");
        }

    } catch (Exception $e) {
        // Deshacer los cambios en caso de error
        mysqli_rollback($conn);

        echo "Error: " . $e->getMessage();
        exit();
    }
}

// Redirigir si se accede a esta página sin usar POST
header("Location: index.php");
exit();
?>
