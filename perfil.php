<?php
session_start();
if (!isset($_SESSION['nick'])) {
    header('location:index.php');
} else {
    $nick = $_SESSION['nick'];
    $nombre = $_SESSION['nombre'];
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <h1>Bienvenido <?php echo $nick ?></h1>
    </body>

    </html>

<?php
}
?>