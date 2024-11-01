<?php

session_start();


    try {

        include_once('conexion.php');
        // Desactvar la autoejecución de consultas
        mysqli_autocommit($con, false);

        // Inicializar una transacción
        mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);

        // Obtener y escapear el id del amigo
        $id = mysqli_real_escape_string($con, $_POST['id']);

        // Preparamos la consulta SQL para insertar una nueva amistad
        $sqlañadir = "INSERT INTO tbl_amistad (id_emisor, id_receptor, boamistad) VALUES (?, ?, 0)";
        $stmt1 = mysqli_prepare($con, $sqlañadir);

        // Asignar los parámetros a la consulta
        mysqli_stmt_bind_param($stmt1, "ii", $_SESSION['id_user'], $id);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt1);

        // Confirmar la transacción
        mysqli_commit($con);

        // Cerrar la declaración
        mysqli_stmt_close($stmt1);

        // Redirigir al perfil (no eliminar la sesión)
        header('Location: ' . '../perfil.php');
        exit();

    } catch (Exception $e) {
        // Si se produce un error, hacer rollback y mostrar mensaje de error
        mysqli_rollback($con);
        header('Location: ' . '../perfil.php');
        echo "Error en la transacción: " . $e->getMessage();

}
?>