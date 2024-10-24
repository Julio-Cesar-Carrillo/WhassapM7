<?php

$id = $_SESSION['id_user'];

$sql = "SELECT a.*, 
        u1.nick_usu AS emisor, 
        u2.nick_usu AS receptor
        FROM tbl_chat AS a
        INNER JOIN tbl_usuarios AS u1 ON a.id_emisor = u1.id_usu
        INNER JOIN tbl_usuarios AS u2 ON a.id_receptor = u2.id_usu  AND (id_emisor = $id OR id_receptor= $id) ORDER BY id_chat DESC;";

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
