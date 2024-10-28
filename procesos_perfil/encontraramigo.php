<?php

include("./conexion.php");
try {
    $id = $_SESSION['id_user'];
    $sql = "SELECT * FROM tbl_usuarios WHERE id_usu <> $id ";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
?>
    <table>
        <tbody>
            <?php
            foreach ($resultado as $fila) {
            ?>
                <tr style="text-align: left;">
                    <td scope="row"><?php echo $fila['id_usu']; ?>
                        <?php echo $fila['nick_usu'] . " | "; ?>
                        <?php echo $fila['nom_usu']; ?>
                    </td>
                    <td>
                        <form action="Aceptar.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $fila['id_usu'] ?>">
                            <input type="submit" value="Añadir">
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php
} catch (Exception $th) {
}
