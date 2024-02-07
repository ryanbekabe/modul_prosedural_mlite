<?php
    $servername = "localhost"; //localhost
    $username = "root"; //root
    $password = "root"; //root
    $database = "sik"; //sik

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
?>
