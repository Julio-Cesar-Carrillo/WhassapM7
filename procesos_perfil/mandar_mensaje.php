<?php
session_start();
include("./conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['mensaje'])) {
    $receptorId = $_POST['id'];
    $mensaje = $_POST['mensaje'];

    try {
        // Grabar mensaje en tbl_chat
        $sql = "INSERT INTO tbl_chat (id_emisor, id_receptor, mensaje_chat, fecha_hora_chat) VALUES (?, ?, ?, NOW())";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $_SESSION['id_user'], $receptorId, $mensaje);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['mensaje'] = "Mensaje enviado con éxito.";
    } catch (Exception $e) {
        $_SESSION['mensaje'] = "Error al enviar el mensaje: " . $e->getMessage();
    } finally {
        mysqli_close($con);
        header("Location: perfil.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = "Solicitud inválida.";
    header("Location: perfil.php");
    exit();
}