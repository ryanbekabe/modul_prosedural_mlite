<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memeriksa apakah pilihan terkirim
    if (isset($_POST['selectedOptions'])) {
        $selectedOptions = $_POST['selectedOptions'];

        // Menampilkan pilihan yang dipilih
        echo "Pilihan yang dipilih:<br>";
        foreach ($selectedOptions as $option) {
            echo $option . " - " . $_POST['textnoorder'] . "<br>";
            // Lakukan operasi penyimpanan ke database atau yang lain sesuai kebutuhan Anda
        }
    } else {
        echo "Tidak ada pilihan yang dipilih.";
    }
}
?>
