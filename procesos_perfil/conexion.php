<?php
$s = "localhost";
$u = "root";
$p = "";
$d = "db_chat";

try {
    $con = mysqli_connect($s, $u, $p, $d);
} catch (Exception $e) {
    echo $e->getMessage();
}
