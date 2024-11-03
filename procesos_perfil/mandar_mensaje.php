<?php
// Iniciar la sesión
session_start();
include("./conexion.php");

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    // Si no ha iniciado sesión, redirige a la página de inicio y sal del script
    header('Location: index.php');
    exit;
}

// Verifica si se han enviado los parámetros `mensaje` y `chat_with` mediante POST
if (isset($_POST['mensaje']) && isset($_POST['chat_with'])) {
    // Limpia el mensaje de espacios en blanco al inicio y al final
    $mensaje = trim($_POST['mensaje']);
    // Convierte el parámetro `chat_with` a un entero
    $idAmigo = (int)$_POST['chat_with'];
    // Obtiene el ID del usuario desde la sesión
    $idUsuario = $_SESSION['id_user'];
    // Obtiene la fecha y hora actual en el formato 'Y-m-d H:i:s'
    $fechaHoraChat = date('Y-m-d H:i:s');

    // Consulta SQL para insertar el mensaje en la tabla `tbl_chat`
    $sql = "INSERT INTO tbl_chat (id_emisor, id_receptor, mensaje_chat, fecha_hora_chat) VALUES (?, ?, ?, ?)";
    // Prepara la consulta SQL
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        // Vincula los parámetros a la consulta preparada
        mysqli_stmt_bind_param($stmt, "iiss", $idUsuario, $idAmigo, $mensaje, $fechaHoraChat);
        // Ejecuta la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            // Si la consulta se ejecuta correctamente, redirige a la página de perfil con el parámetro `chat_with`
            header("Location: ../perfil.php?chat_with=" . $idAmigo);
            exit;
        } else {
            // Si hay un error al ejecutar la consulta, muestra un mensaje de error
            echo "<p>Error al enviar el mensaje: " . mysqli_error($con) . "</p>";
        }
        // Cierra la declaración preparada
        mysqli_stmt_close($stmt);
    } else {
        // Si hay un error al preparar la consulta, muestra un mensaje de error
        echo "<p>Error en la consulta: " . mysqli_error($con) . "</p>";
    }
} else {
    // Si no se envían los parámetros `mensaje` y `chat_with`, muestra un mensaje pidiendo escribir un mensaje
    echo "<p>Por favor, escribe un mensaje.</p>";
}
?>