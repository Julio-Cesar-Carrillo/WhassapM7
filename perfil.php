<?php
session_start();
if (!isset($_SESSION['nick'])) {
    header('location:index.php');
} else {

    include './conexion.php';

    $nick = $_SESSION['nick'];
    $nombre = $_SESSION['nombre'];
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

    <body>
        <h2>Bienvenido <?php echo $nick ?></h2>

        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">
                    <?php
                    include './procesos_perfil/amigos.php';
                    ?>
                </div>
                <div class="col">
                    <?php
                    include './procesos_perfil/chat.php';
                    ?>
                </div>
                <div class="col">
                    One of three columns
                </div>
            </div>
        </div>
    </body>

    </html>

<?php
}
?>