<?php

$server = $_SERVER['SERVER_NAME'] ?? '';

/*
|--------------------------------------------------------------------------
| InfinityFree Hosting
|--------------------------------------------------------------------------
*/
if (
    strpos($server, 'dreamgadgetstore.gt.tc') !== false ||
    strpos($server, 'epizy.com') !== false ||
    strpos($server, 'infinityfreeapp.com') !== false
) {

    $host = "sql300.infinityfree.com";
    $user = "if0_42269432";
    $pass = "suL3T4AFYY";
    $db   = "if0_42269432_dream_gadget_store";
}

/*
|--------------------------------------------------------------------------
| Docker
|--------------------------------------------------------------------------
*/
elseif (file_exists('/.dockerenv')) {

    $host = "mysql";
    $user = "dreamuser";
    $pass = "dreampass";
    $db   = "dream_gadget_store1";
}

/*
|--------------------------------------------------------------------------
| XAMPP Localhost
|--------------------------------------------------------------------------
*/
else {

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "dream_gadget_store1";
}

/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>