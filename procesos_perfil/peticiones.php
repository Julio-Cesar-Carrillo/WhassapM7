<table class="table" border="1px">
    <thead>
        <tr>
            <th scope="col">Solicitud de amigos</th>
            <th scope="col">acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $id = $_SESSION['id_user'];

        $sql = "SELECT a.*, 
        u1.nick_usu AS emisor, 
        u2.nick_usu AS receptor
        FROM tbl_amistad AS a
        INNER JOIN tbl_usuarios AS u1 ON a.id_emisor = u1.id_usu
        INNER JOIN tbl_usuarios AS u2 ON a.id_receptor = u2.id_usu AND boamistad=0  AND (id_emisor = $id OR id_receptor= $id);";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        foreach ($resultado as $fila) {
        ?>
            <tr>
                <td><?php echo $fila['id_emisor'] == $id ? $fila['receptor'] : $fila['emisor']; ?></td>
                <td>
                    <form action="./procesos_perfil/aceptar.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $fila['id_emisor'] == $id ? $fila['id_receptor'] : $fila['id_emisor']; ?>">
                        <input type="submit" value="Aceptar">
                    </form>
                    <!-- </td>
                <td> -->
                    <form action="./procesos_perfil/eliminar_amigo.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $fila['id_emisor'] == $id ? $fila['id_receptor'] : $fila['id_emisor']; ?>">
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            <?php
        }
            ?>
            </tr>
    </tbody>
</table>