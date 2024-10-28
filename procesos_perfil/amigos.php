<?php

$id = $_SESSION['id_user'];

$sql = "SELECT a.*, 
        u1.nick_usu AS emisor, 
        u2.nick_usu AS receptor
        FROM tbl_amistad AS a
        INNER JOIN tbl_usuarios AS u1 ON a.id_emisor = u1.id_usu
        INNER JOIN tbl_usuarios AS u2 ON a.id_receptor = u2.id_usu
        WHERE boamistad = 1 AND (id_emisor = ? OR id_receptor = ?)";

$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id, $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<table class="table" border="1px">
    <thead>
    <tr>
        <th scope="col">Amigo</th>
        <th scope="col">acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $amigoId = $fila['id_emisor'] == $id ? $fila['id_receptor'] : $fila['id_emisor'];
        $amigoNick = $fila['id_emisor'] == $id ? $fila['receptor'] : $fila['emisor'];
        ?>
        <tr>
            <td><?php echo htmlspecialchars($amigoNick, ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
                <!-- Formulario para enviar mensaje y eliminar amigo -->
                <form action="./procesos_perfil/mandar_mensaje.php" method="post" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $amigoId; ?>">
                    <input type="submit" value="Mensaje">
                </form>
                <form action="./procesos_perfil/eliminar_amigo.php" method="post" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $amigoId; ?>">
                    <input type="submit" value="Eliminar">
                </form>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>