<?php

include("./procesos_perfil/conexion.php");

// Guardar el término de búsqueda en sesión si está definido
if (isset($_GET['search'])) {
    $_SESSION['searchTerm'] = $_GET['search'];
}

// Recuperar el término de búsqueda desde la sesión o establecerlo vacío si no existe
$searchTerm = isset($_SESSION['searchTerm']) ? $_SESSION['searchTerm'] : '';
?>

<form method="get">
    <input type="text" name="search" placeholder="Buscar amigo..." value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="submit" value="Buscar">
</form>

<?php
try {
    $id = $_SESSION['id_user'];
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
        // Vinculamos seis parámetros si hay un término de búsqueda
        mysqli_stmt_bind_param($stmt, 'iiiiss', $id, $id, $id, $id, $searchPattern, $searchPattern);
    } else {
        // Vinculamos solo cuatro parámetros cuando no hay término de búsqueda
        mysqli_stmt_bind_param($stmt, 'iiii', $id, $id, $id, $id);
    }

    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Mostrar resultados solo si hay búsqueda y resultados
    if (!empty($searchTerm) && mysqli_num_rows($resultado) > 0) : ?>
        <table>
            <tbody>
                <?php foreach ($resultado as $fila) : ?>
                    <tr style="text-align: left;">
                        <td scope="row">
                            <?php echo htmlspecialchars($fila['nick_usu']) . " | " . htmlspecialchars($fila['nom_usu']); ?>
                        </td>
                        <td>
                            <form action="./procesos_perfil/añadir_amigo.php" method="post">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($fila['id_usu']); ?>">
                                <input type="submit" value="Añadir">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (!empty($searchTerm)) : ?>
        <p>No se encontraron resultados para "<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>"</p>
    <?php endif; ?>

<?php
} catch (Exception $th) {
    echo "Error: " . $th->getMessage();
}
?>