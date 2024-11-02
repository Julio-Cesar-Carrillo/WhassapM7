<?php
session_start();
include("./conexion.php");

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['mensaje']) && isset($_POST['chat_with'])) {
    $mensaje = trim($_POST['mensaje']);
    $idAmigo = (int)$_POST['chat_with'];
    $idUsuario = $_SESSION['id_user'];
    $fechaHoraChat = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual

    // Insertar el mensaje en la base de datos
    $sql = "INSERT INTO tbl_chat (id_emisor, id_receptor, mensaje_chat, fecha_hora_chat) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iiss", $idUsuario, $idAmigo, $mensaje, $fechaHoraChat);
        if (mysqli_stmt_execute($stmt)) {
            // Mensaje enviado correctamente
            header("Location: ../perfil.php?chat_with=" . $idAmigo); // Redirige al perfil y agrega el amigo con el que se chatea
            exit;
        } else {
            echo "<p>Error al enviar el mensaje: " . mysqli_error($con) . "</p>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<p>Error en la consulta: " . mysqli_error($con) . "</p>";
    }
} else {
    echo "<p>Por favor, escribe un mensaje.</p>";
}
