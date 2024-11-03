<?php
include("./conexion.php");

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
} else {

    if (isset($_GET['chat_with'])) {
        $idAmigo = (int)$_GET['chat_with'];
        $idUsuario = $_SESSION['id_user'];

        // Consulta para obtener los mensajes solo entre el usuario actual y el amigo específico
        $sql = "SELECT a.*, u1.nick_usu AS emisor, u2.nick_usu AS receptor
            FROM tbl_chat AS a
            INNER JOIN tbl_usuarios AS u1 ON a.id_emisor = u1.id_usu
            INNER JOIN tbl_usuarios AS u2 ON a.id_receptor = u2.id_usu
            WHERE (a.id_emisor = ? AND a.id_receptor = ?) OR (a.id_emisor = ? AND a.id_receptor = ?)
            ORDER BY a.fecha_hora_chat ASC";

        $stmt = mysqli_prepare($con, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iiii", $idUsuario, $idAmigo, $idAmigo, $idUsuario);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($resultado) > 0) {
                // Mostrar los mensajes en el chat
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    if ($fila['id_emisor'] == $idUsuario) {
                        echo "<div class='text-end'><p class='bg-primary text-white rounded p-2 d-inline-block'>" . htmlspecialchars($fila['mensaje_chat'], ENT_QUOTES, 'UTF-8') . "</p><span class='small'>: Tú</span></div>";
                    } else {
                        echo "<div class='text-start'><span class='small'>" . htmlspecialchars($fila['emisor'], ENT_QUOTES, 'UTF-8') . ":</span><p class='bg-secondary text-white rounded p-2 d-inline-block'>" . htmlspecialchars($fila['mensaje_chat'], ENT_QUOTES, 'UTF-8') . "</p></div>";
                    }
                }
                // Formulario para enviar mensajes
?>
                <form action="./procesos_perfil/mandar_mensaje.php" method="post" class="mt-3">
                    <div class="input-group">
                        <input type="hidden" name="chat_with" value="<?php echo $idAmigo; ?>">
                        <input type="text" name="mensaje" class="form-control" placeholder="Escribe tu mensaje..." required>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            <?php
            } else {
                echo "<p>No hay mensajes entre tú y este usuario.</p>";
                // Formulario para enviar mensajes
            ?>
                <form action="./procesos_perfil/mandar_mensaje.php" method="post" class="mt-3">
                    <div class="input-group">
                        <input type="hidden" name="chat_with" value="<?php echo htmlspecialchars($idAmigo, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="text" name="mensaje" class="form-control" placeholder="Escribe tu mensaje..." required>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
<?php
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<p>Error en la consulta: " . mysqli_error($con) . "</p>";
        }
    } else {
        echo "<p>Selecciona un amigo para ver el chat.</p>";
    }
}
?>