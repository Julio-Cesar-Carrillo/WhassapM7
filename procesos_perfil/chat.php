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
        <?php if ($fila['id_emisor'] == $id) { ?>
            <p style="text-align:left">
                <?php echo $fila['receptor']." :" ?>
                <br>
                <?php echo $fila['mensaje_chat']; ?>
            </p>
        <?php } else { ?>
            <p style="text-align:right">
                <?php echo $fila['receptor']." :" ?>
                <br>
                <?php echo $fila['mensaje_chat']; ?>
            </p>
        <?php } ?>
    </div>
<?php
}