<?php

include("./procesos_perfil/conexion.php");
try {
    $id = $_SESSION['id_user'];
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    // Revisar la cadena de búsqueda
    $searchCondition = "";
    if (!empty($searchTerm)) {
        $searchCondition = "AND (u.nick_usu LIKE ? OR u.nom_usu LIKE ?)";
    }

    $sql = "SELECT u.*
    FROM tbl_usuarios u
    LEFT JOIN tbl_amistad a_emisor ON u.id_usu = a_emisor.id_emisor
    LEFT JOIN tbl_amistad a_receptor ON u.id_usu = a_receptor.id_receptor
    WHERE u.id_usu != ? 
    AND a_emisor.id_amistad IS NULL 
    AND a_receptor.id_amistad IS NULL 
    $searchCondition";

    $stmt = mysqli_prepare($con, $sql);

    // Vincular parámetros según haya o no búsqueda
    if (!empty($searchTerm)) {
        $searchPattern = '%' . $searchTerm . '%';
        mysqli_stmt_bind_param($stmt, 'iss', $id, $searchPattern, $searchPattern);
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id);
    }

    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    ?>
    <form method="get">
        <input type="text" name="search" placeholder="Buscar amigo..." value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="submit" value="Buscar">
    </form>

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
    <?php
} catch (Exception $th) {
    // Manejo de excepciones de manera adecuada
    echo "Error: " . $th->getMessage();
}
?>