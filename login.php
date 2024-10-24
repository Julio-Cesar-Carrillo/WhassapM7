<?php
// Iniciar sesión
session_start();
$_SESSION['error_username'] = $_SESSION['error_password'] = "";
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
    try {
        include "./conexion.php";
        // $name = mysqli_real_escape_string($con, $_POST['nick']);
        // $pwd = mysqli_real_escape_string($con, $_POST['pwd']);
        $name = "Darckfer";
        $pwd = "qweQWE123";
        $sql = "SELECT * FROM tbl_usuarios WHERE nick_usu=?";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $name);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            $num_rows = mysqli_num_rows($resultado);
            if ($num_rows > 0) {
                $fila = mysqli_fetch_assoc($resultado);
                if (password_verify($pwd, $fila['pwd_usu'])) {
                    session_start();
                    $_SESSION['nick'] = $fila['nick_usu'];
                    $_SESSION['nombre'] = $fila['nom_usu'];
                    header('location: perfil.php');
                }
            }
        }
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        mysqli_close($con);
        die();
    }
}
// Redirigir si accede a esta página sin POST
header("Location: index.php");
exit();