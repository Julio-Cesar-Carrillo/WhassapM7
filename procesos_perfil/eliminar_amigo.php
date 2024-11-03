<?php
session_start();
include("./conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $amigoId = $_POST['id'];
    try {
        // Iniciar transacción
        mysqli_autocommit($con, false);
        mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);

        // Eliminar amistad
        $sql = "DELETE FROM tbl_amistad 
                WHERE (id_emisor = ? AND id_receptor = ?) 
                OR (id_emisor = ? AND id_receptor = ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iiii", $amigoId, $_SESSION['id_user'], $_SESSION['id_user'], $amigoId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Eliminar historial de chat
        $sqlChat = "DELETE FROM tbl_chat 
                     WHERE (id_emisor = ? AND id_receptor = ?) 
                     OR (id_emisor = ? AND id_receptor = ?)";
        $stmtChat = mysqli_prepare($con, $sqlChat);
        mysqli_stmt_bind_param($stmtChat, "iiii", $amigoId, $_SESSION['id_user'], $_SESSION['id_user'], $amigoId);
        mysqli_stmt_execute($stmtChat);
        mysqli_stmt_close($stmtChat);

        // Commit de la transacción
        mysqli_commit($con);
    } catch (Exception $e) {
        mysqli_rollback($con);
    }
    mysqli_close($con);
    header("Location: ../perfil.php");
    exit();
} else {
    $_SESSION['mensaje'] = "Solicitud inválida.";
    header("Location: ../perfil.php");
    exit();
}
