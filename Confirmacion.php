<?php
session_start();

if (!isset($_SESSION['registro_exitoso'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION['registro_exitoso']; ?>
    </div>
    <a href="login.php" class="btn btn-primary">Ir a Inicio de Sesión</a>
</div>
<?php
// Limpiar la sesión
session_unset();
session_destroy();
?>
</body>
</html>
