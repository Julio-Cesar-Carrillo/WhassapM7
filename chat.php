<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php session_start();
            echo 'Escribiendo a ' . $_GET['nom'] ?></title>
</head>

<body>
    <h1><?php echo 'Estas teniendo una conversasion con: ' . $_GET['nom'] ?></h1>
</body>

</html>