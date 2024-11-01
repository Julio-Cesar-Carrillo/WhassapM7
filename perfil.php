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
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Perfil del Usuario</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
            .welcome {
                margin-top: 20px;
            }

            .card-custom {
                margin: 20px 0;
            }

            body {
                background-color: #343a40;
            }
        </style>
    </head>

    <body class="text-white">
        <div class="container text-center welcome">
            <h2 class="my-4">Bienvenido, <?php echo htmlspecialchars($nick, ENT_QUOTES, 'UTF-8'); ?>!</h2>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-custom bg-secondary text-white">
                        <div class="card-header">
                            Amigos
                        </div>
                        <div class="card-body">
                            <?php include './procesos_perfil/amigos.php'; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card card-custom bg-secondary text-white">
                        <div class="card-header">
                            Chat
                        </div>
                        <div class="card-body">
                            <?php include './procesos_perfil/chat.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12">
                    <div class="card card-custom bg-secondary text-white">
                        <div class="card-header">
                            Encuantra a un amigo
                        </div>
                        <div class="card-body">
                            <?php include_once './procesos_perfil/encontraramigo.php'; ?>
                        </div>
                        <div class="card-header">
                            Peticiones
                        </div>
                        <div class="card-body">
                            <?php include_once './procesos_perfil/peticiones.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS y dependencias -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybIVfK4x2KSjF9FNUd1clS6zepcaZG8RZ7v0dkK8eQf6XA7ap" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12W90NgdGSjc3zE3qkTa6Uks92IWDy465F8LRjUAs9fvg9Kx" crossorigin="anonymous"></script>
    </body>

    </html>

<?php
}
?>