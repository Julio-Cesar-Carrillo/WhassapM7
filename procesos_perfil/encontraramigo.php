<?php

// Incluye el archivo que contiene la conexión a la base de datos
include("./procesos_perfil/conexion.php");

// Guardar el término de búsqueda en la sesión si está definido
if (isset($_GET['search'])) {
    $_SESSION['searchTerm'] = $_GET['search'];
}

// Recuperar el término de búsqueda desde la sesión, o establecerlo como una cadena vacía si no existe
$searchTerm = isset($_SESSION['searchTerm']) ? $_SESSION['searchTerm'] : '';
?>

    <!-- Formulario de búsqueda -->
    <form method="get">
        <!-- Campo de texto para ingresar el término de búsqueda, con valor previamente buscado -->
        <input type="text" name="search" class="form-control" placeholder="Buscar amigo..." value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>">
        <!-- Botón para enviar el formulario de búsqueda -->
        <input type="submit" class="btn btn-primary" value="Buscar">
    </form>

<?php
try {
    // Obtener el ID del usuario actual desde la sesión
    $id = $_SESSION['id_user'];
    $searchCondition = "";

    // Si hay un término de búsqueda, agregar una condición de búsqueda a la consulta SQL
    if (!empty($searchTerm)) {
        $searchCondition = "AND (u.nick_usu LIKE ? OR u.nom_usu LIKE ?)";
    }

    // Construcción de la consulta SQL para buscar usuarios que no sean el usuario actual
    // y que no estén ya en la lista de amigos del usuario actual
    $sql = "SELECT u.* 
    FROM tbl_usuarios u
    WHERE u.id_usu != ? 
    AND u.id_usu NOT IN (
        SELECT CASE WHEN a.id_emisor = ? THEN a.id_receptor ELSE a.id_emisor END
        FROM tbl_amistad a
        WHERE (a.id_emisor = ? OR a.id_receptor = ?)
    )
    $searchCondition";

    // Preparar la consulta SQL
    $stmt = mysqli_prepare($con, $sql);

    if (!empty($searchTerm)) {
        // Si hay un término de búsqueda, crear el patrón de búsqueda
        $searchPattern = '%' . $searchTerm . '%';
        // Vincular los parámetros a la declaración preparada (6 en total)
        mysqli_stmt_bind_param($stmt, 'iiiiss', $id, $id, $id, $id, $searchPattern, $searchPattern);
    } else {
        // Vincular los parámetros a la declaración preparada (4 en total)
        mysqli_stmt_bind_param($stmt, 'iiii', $id, $id, $id, $id);
    }

    // Ejecutar la consulta
    mysqli_stmt_execute($stmt);
    // Obtener el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Mostrar resultados solo si hay un término de búsqueda y se encuentran resultados
    if (!empty($searchTerm) && mysqli_num_rows($resultado) > 0) : ?>
        <!-- Tabla para mostrar los resultados -->
        <table>
            <tbody>
            <!-- Iterar sobre cada fila del resultado -->
            <?php foreach ($resultado as $fila) : ?>
                <tr style="text-align: left;">
                    <td scope="row">
                        <!-- Mostrar el nombre de usuario y el nombre del usuario asegurándose de que el HTML sea seguro -->
                        <?php echo htmlspecialchars($fila['nick_usu']) . " | " . htmlspecialchars($fila['nom_usu']); ?>
                    </td>
                    <td>
                        <!-- Formulario para añadir al usuario como amigo -->
                        <form action="./procesos_perfil/añadir_amigo.php" method="post">
                            <!-- Campo oculto con el ID del usuario a añadir -->
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($fila['id_usu']); ?>">
                            <!-- Botón para enviar la solicitud de amistad -->
                            <input type="submit" value="Añadir">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (!empty($searchTerm)) : ?>
        <!-- Mensaje en caso de que no se encuentren resultados -->
        <p>No se encontraron resultados para "<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>"</p>
    <?php endif; ?>

    <?php
} catch (Exception $th) {
    // Manejo de errores
    echo "Error: " . $th->getMessage();
}
?>