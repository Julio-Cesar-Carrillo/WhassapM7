<?php

// Incluye el archivo de la conexión a la base de datos
include("../conexion.php");

// Inicia la sesión
session_start();

// Verifica si se ha enviado el "id" a través de POST
if (isset($_POST["id"])) {
    try {
        // Escapa caracteres especiales en una cadena para usar en una consulta SQL
        $id_amigo = mysqli_real_escape_string($con, $_POST['id']);
        $id_user = $_SESSION['id_user'];

        // Inicia una transacción
        mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);

        // Prepara la consulta SQL para actualizar el estado de amistad
        $sqlaceptar = "UPDATE tbl_amistad SET boamistad = ? 
                       WHERE (id_emisor = ? OR id_emisor = ?) 
                       AND (id_receptor = ? OR id_receptor = ?);";

        // Inicializa una declaración
        $stmt = mysqli_stmt_init($con);
        // Prepara la declaración SQL
        mysqli_stmt_prepare($stmt, $sqlaceptar);

        // Valor para el campo 'boamistad' (1 significa amistad aceptada)
        $boamistad = 1;
        // Vincula las variables a la declaración preparada como parámetros
        mysqli_stmt_bind_param($stmt, "iiiii", $boamistad, $id_user, $id_amigo, $id_user, $id_amigo);

        // Ejecuta la declaración
        mysqli_stmt_execute($stmt);

        // Si todo salió bien, confirma los cambios realizados durante la transacción
        mysqli_commit($con);

        // Cierra la declaración y la conexión a la base de datos
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        // Redirige al usuario a la página de perfil
        header("location:../perfil.php");
        exit();
    } catch (Exception $e) {
        // Si ocurre un error, revierte todos los cambios realizados durante la transacción
        mysqli_rollback($con);
        echo "Error al Aceptar a el amigo: " . $e->getMessage();

        // Cierra la declaración y la conexión a la base de datos
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        exit();
    }
} else {
    // Si no se ha enviado el "id" a través de POST, redirige al usuario a la página de perfil
    header("location:../perfil.php");
}