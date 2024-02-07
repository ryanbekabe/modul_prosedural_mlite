<?php
include 'conf.php';

$namatabledb = 'template_laboratorium';
$namatabledbb = 'jns_perawatan_lab';
$kolom1 = 'kd_jenis_prw';
$kolom1b = 'kd_jenis_prw';
$kolom2 = 'id_template';
$kolom2b = 'nm_perawatan';
$kolom3 = 'Pemeriksaan';
$kolom3b = 'kd_pj';
$kolom4 = 'satuan';
$kolom4b = 'status';

// Mendapatkan query pencarian dari permintaan AJAX
$searchQuery = $_POST['searchQuery'];

// Query untuk mencari data berdasarkan query pencarian (gantilah nama_tabel dan nama_kolom sesuai kebutuhan)
// $sql = "SELECT * FROM $namatabledb WHERE $kolom3 LIKE '%$searchQuery%' LIMIT 10";
        // Query pencarian dengan INNER JOIN (gantilah nama_tabel1, nama_kolom1, nama_tabel2, dan nama_kolom2 sesuai kebutuhan)

// $sql = "SELECT $namatabledb.$kolom1, $namatabledb.$kolom2, $namatabledb.$kolom3, 
//         FROM $namatabledb
//         INNER JOIN $namatabledb2 ON $namatabledb.$kolom1 = $namatabledb.$kolom1
//         WHERE $namatabledb.$kolom3 LIKE '%$searchQuery%'";
//             // -- OR nama_tabel2.nama_kolom2 LIKE '%$searchQuery%'";

$sql = "SELECT `$namatabledb`.`$kolom3`,`$namatabledb`.`$kolom2`,`$namatabledb`.`$kolom1`
    FROM `$namatabledb`
    INNER JOIN `$namatabledbb` ON `$namatabledb`.`$kolom1` = `$namatabledbb`.`$kolom1`
    WHERE `$namatabledb`.`$kolom3` LIKE '%$searchQuery%'
    LIMIT 10";

// $sql = "SELECT $namatabledb.$kolom1, $namatabledb.$kolom2, $namatabledb.$kolom3 FROM $namatabledb WHERE $namatabledb.$kolom3 LIKE '%$searchQuery%' LIMIT 10";
$result = $conn->query($sql);

// Menampilkan hasil rekomendasi sebagai checkbox
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<input type='checkbox' name='selectedOptions[]' value='" . $row[$kolom1] . "|" . $row[$kolom2] . "'>".  $row[$kolom3] . " - " . $row[$kolom1] . " - " . $row[$kolom2] . "<br>";
    }
} else {
    echo "<div>Tidak ada hasil.</div>";
}

$conn->close();
?>
