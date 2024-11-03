<?php

include("./procesos_perfil/conexion.php");

try {
    $id = $_SESSION['id_user'];
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    $searchCondition = "";
    if (!empty($searchTerm)) {
        $searchCondition = "AND (u.nick_usu LIKE ? OR u.nom_usu LIKE ?)";
    }

    $sql = "SELECT u.* 
    FROM tbl_usuarios u
    WHERE u.id_usu != ? 
    AND u.id_usu NOT IN (
        SELECT CASE WHEN a.id_emisor = ? THEN a.id_receptor ELSE a.id_emisor END
        FROM tbl_amistad a
        WHERE (a.id_emisor = ? OR a.id_receptor = ?)
    )
    $searchCondition";

    $stmt = mysqli_prepare($con, $sql);

    if (!empty($searchTerm)) {
        $searchPattern = '%' . $searchTerm . '%';
        mysqli_stmt_bind_param($stmt, 'iiiiss', $id,  $id, $id, $id, $searchPattern, $searchPattern);
    } else {
        mysqli_stmt_bind_param($stmt, 'iiii', $id, $id, $id, $id);
    }

    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
?>
    <form method="get">
        <input type="text" name="search" placeholder="Buscar amigo..." value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="submit" value="Buscar">
    </form>

    <?php if (!empty($searchTerm) && mysqli_num_rows($resultado) > 0) : ?>
        <table>
            <tbody>
                <?php
                foreach ($resultado as $fila) {
                ?>
                    <tr style="text-align: left;">
                        <!-- <?php echo $fila['id_usu']; ?> -->
                        <td scope="row"> <?php echo $fila['nick_usu'] . " | "; ?>
                            <?php echo $fila['nom_usu']; ?>
                        </td>
                        <td>
                            <form action="./procesos_perfil/añadir_amigo.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $fila['id_usu']; ?>">
                                <input type="submit" value="Añadir">
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php elseif (!empty($searchTerm)) : ?>
        <p>No se encontraron resultados para "<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>"</p>
    <?php endif; ?>

<?php
} catch (Exception $th) {
    // Manejo de excepciones de manera adecuada
    echo "Error: " . $th->getMessage();
}
?>