<?php
    $servername = "192.168.88.99"; //localhost
    $username = "pku1912"; //root
    $password = "pku1912"; //root
    $database = "sik"; //sik

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
?>
