<?php
if (isset($_POST['iniciarchat'])) {
    session_start();
    include('./conexion.php');
    $_SESSION['id_chat_con'] = $_POST['iniciarchat'];
    $id_chat = $_POST['iniciarchat'];

    $id = $_SESSION['id_user'];

    $sql = "SELECT a.*, 
            u1.nick_usu AS emisor, 
            u2.nick_usu AS receptor
            FROM tbl_chat AS a
            INNER JOIN tbl_usuarios AS u1 ON a.id_emisor = u1.id_usu
            INNER JOIN tbl_usuarios AS u2 ON a.id_receptor = u2.id_usu  AND (id_emisor = $id OR id_receptor= $id) AND (id_emisor = $id_chat OR id_receptor= $id_chat) ORDER BY id_chat DESC;";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    foreach ($resultado as $fila) {
?>
        <div>
            <?php echo $fila['id_emisor'] == $id ?
                // Si es igual 
                "<p style= 'text-align:left'>" . $fila['receptor'] . ": " . $fila['mensaje_chat'] . "</p>"
                // Si no es igual
                : "<p style= 'text-align:rigth'>" . $fila['mensaje_chat'] . " :" . $fila['receptor'] . "</p>"; ?>

        </div>
    <?php
    }
    ?>

    <form action="" method="post">
        <input type="text" id="mensaje" placeholder="Escribe un mensaje">
        <input type="submit" value="Enviar">
    </form>
<?php
    header('location:../perfil.php');
}
