<table class="table" border="1px">
    <thead>
        <tr>
            <th scope="col">Solicitud de amigos</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $id = $_SESSION['id_user'];

        $sql = "SELECT a.*, 
                       u1.nick_usu AS emisor
                FROM tbl_amistad AS a
                INNER JOIN tbl_usuarios AS u1 ON a.id_emisor = u1.id_usu
                WHERE a.id_receptor = ? 
                AND a.boamistad = 0";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        foreach ($resultado as $fila) {
        ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['emisor']); ?></td>
                <td>
                    <form action="./procesos_perfil/aceptar.php" method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $fila['id_emisor']; ?>">
                        <input type="submit" class="btn btn-primary btn-sm" value="Aceptar">
                    </form>

                    <form action="./procesos_perfil/eliminar_amigo.php" method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $fila['id_emisor']; ?>">
                        <input type="submit" class="btn btn-danger btn-sm" value="Eliminar">
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>