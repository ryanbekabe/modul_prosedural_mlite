<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $database = "sik";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
?>
