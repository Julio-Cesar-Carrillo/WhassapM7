<?php

include("./conexion.php");

session_start();

if (isset($_POST["id"])) {
    try {
        $id_amigo = mysqli_real_escape_string($con, $_POST['id']);
        $id_user = $_SESSION['id_user'];

        mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);

        $sqlaceptar = "UPDATE tbl_amistad SET boamistad = ? 
                   WHERE (id_emisor = ? OR id_emisor = ?) 
                   AND (id_receptor = ? OR id_receptor = ?);";

        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $sqlaceptar);


        $boamistad = 1;
        mysqli_stmt_bind_param($stmt, "iiiii", $boamistad, $id_user, $id_amigo, $id_user, $id_amigo);

        mysqli_stmt_execute($stmt);


        mysqli_commit($con);
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        header("location:../perfil.php");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo "Error al Aceptar a el amigo: " . $e->getMessage();
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        exit();
    }
} else {
    header("location:../perfil.php");
}
