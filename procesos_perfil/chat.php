<?php

$id = $_SESSION['id_user'];

$sql = "SELECT a.*, 
        u1.nick_usu AS emisor, 
        u2.nick_usu AS receptor
        FROM tbl_amistad AS a
        INNER JOIN tbl_usuarios AS u1 ON a.id_emisor = u1.id_usu
        INNER JOIN tbl_usuarios AS u2 ON a.id_receptor = u2.id_usu AND boamistad=1  AND (id_emisor = $id OR id_receptor= $id);";

$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
foreach ($resultado as $fila) {
?>
    <div>
        
    </div>
<?php
}