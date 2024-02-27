<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul Pencarian RME</title>
    <!-- <script src="jquery-3.6.4.min.js"></script> -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
</head>
<body>
    <h2>Pencarian Sample Lab.</h2>

<?php
include 'conf.php';
// Periksa apakah parameter 'id' ada dalam URL
//http://localhost/lab/mlite20012024/?id=2024/02/04/000001
date_default_timezone_set('Asia/Jakarta');
// Mendapatkan link saat ini
$currentURL = "http";
// if ($_SERVER["HTTPS"] == "on") {
//     $currentURL .= "s";
// }
$currentURL .= "://" . $_SERVER["SERVER_NAME"];

// Jika port bukan port default (80 atau 443), tambahkan ke URL
if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
    $currentURL .= ":" . $_SERVER["SERVER_PORT"];
}

// Tambahkan path dan query string (jika ada)
$currentURL .= $_SERVER["REQUEST_URI"];

Global $id;
Global $un;
Global $kolom1dokx;
Global $statusnoorder;
Global $varnextnoorder;
Global $vargetkdjenisprw;
Global $varnoorderx;

function sanitize($input) 
{
    if(is_array($input)):
        foreach($input as $key=>$value):
            $result[$key] = sanitize($value);
        endforeach;
    else:
        $result = htmlentities($input, ENT_QUOTES, 'UTF-8');
    endif;
    return $result;
}

if (isset($_GET['id']) && isset($_GET["un"]) && !empty($_GET["id"]) && !empty($_GET["un"])) {
    // Dapatkan nilai 'id'
    $id = $_GET['id'];
    $un = sanitize($_GET['un']);
    // echo "Nilai id dan un yang diterima: $id, $un";
    echo "";
} else {
    // echo "Tidak ada parameter 'id' dalam URL.";
    echo "";
}

if (isset($_GET['kd_jenis_prw'])){
    $vargetkdjenisprw = $_GET['kd_jenis_prw'];
}


$unnostrip = strstr($un, '-', true);

// echo '<br>';

$namatabledbppl = 'permintaan_pemeriksaan_lab';
$namatabledbdpdpl = 'permintaan_detail_permintaan_lab';
$namatabledbjnpl = 'jns_perawatan_lab';
$namatabledbdok = 'dokter';
$namatabledb = 'permintaan_lab';
$kolom1 = 'noorder';
$kolom1dok = 'kd_dokter';
$kolom1noordr = 'noorder';
$kolom2 = 'no_rawat ';
$kolom2dok = 'nm_dokter ';
$kolom2kdjp = 'kd_jenis_prw ';
$kolom3 = 'tgl_permintaan';
$kolom3idtmplt = 'id_template';
$kolom4 = 'jam_permintaan';
$kolom4sb = 'stts_bayar';
$kolom5 = 'tgl_sampel';
$kolom6 = 'jam_sampel';
$kolom7 = 'tgl_hasil';
$kolom8 = 'jam_hasil';
$kolom9 = 'dokter_perujuk';
$kolom10 = 'status';
$kolom11 = 'informasi_tambahan';
$kolom12 = 'diagnosa_klinis';

$val1 = 'PL'.date('Ymd').'0001';
$val2 = $id;
$val3 = date('Y-m-d');
$val4 = date('H:i:s');
$val5 = "0000-00-00"; //date('Y-m-d');
$val6 = "00:00:00";
$val7 = "0000-00-00"; //date('Y-m-d');
$val8 = "00:00:00";
$val9 = "DR001";
$val10 = "ralan";
$val11 = "-";
$val12 = "-";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memeriksa apakah pilihan terkirim
    if (isset($_POST['selectedOptions'])) {
        $selectedOptions = $_POST['selectedOptions'];

        // Menampilkan pilihan yang dipilih
        echo "<====================><br>";
        echo "Pilihan yang dipilih:<br>";
        foreach ($selectedOptions as $option) {
            echo "Samplenya: ".$option . " - " . $_POST['textnoorder'] . "<br>";
            $kolom1noord = $_POST['textnoorder'];
            $dataString = $option;
            $dataArray = explode("|", $dataString);
            $nilai1 = $dataArray[0];
            $nilai2 = $dataArray[1];
            echo "Nilai 1: $nilai1<br>";
            echo "Nilai 2: $nilai2<br>";            
            // Lakukan operasi penyimpanan ke database atau yang lain sesuai kebutuhan Anda

            $sqlcekdpdpl = "SELECT * FROM $namatabledbdpdpl WHERE $kolom1noordr = '$kolom1noord' AND $kolom2kdjp = '$nilai1' AND $kolom3idtmplt = '$nilai2'";
            $resultcdpdpl = mysqli_query($conn, $sqlcekdpdpl);
            if ($resultcdpdpl->num_rows > 0) {
                    echo "Data $kolom1noordr dan $kolom2kdjp dan $kolom3idtmplt sudah ada.<br>";
            } else {

                $sqldpdpl = "INSERT INTO $namatabledbdpdpl ($kolom1noordr, $kolom2kdjp, $kolom3idtmplt, $kolom4sb) 
                            VALUES                         ('$kolom1noord', '$nilai1', '$nilai2', 'Belum')";
                if (mysqli_query($conn, $sqldpdpl)) {
                    echo "Data permintaan_detail_permintaan_lab berhasil ditambahkan.<br>";
                } else {
                    echo "Error: " . $sqldpdpl . "<br>" . mysqli_error($conn);
                }
            }

            $sqlcekjp = "SELECT * FROM $namatabledbppl WHERE $kolom1noordr = '$kolom1noord' AND $kolom2kdjp = '$nilai1'";
            $resultcjp = mysqli_query($conn, $sqlcekjp);
            if ($resultcjp->num_rows > 0) {
                    echo "Data kd_jenis_prw sudah ada.<br>";
            } else {
                $sqlppl = "INSERT INTO $namatabledbppl ($kolom1noordr, $kolom2kdjp, $kolom4sb) 
                            VALUES                     ('$kolom1noord', '$nilai1', 'Belum')";
                if (mysqli_query($conn, $sqlppl)) {
                    echo "Data kd_jenis_prw belum ada dan berhasil ditambahkan.<br>";
                } else {
                    echo "Error: " . $sqlppl . "<br>" . mysqli_error($conn);
                }
            }
        }
        echo "<====================><br>";
    } else {
        echo "Tidak ada pilihan yang dipilih.";
    }
}


$sqlCount = "SELECT COUNT(*) as total FROM $namatabledb WHERE $kolom3 = '$val3'";
$resultCount = $conn->query($sqlCount);
if ($resultCount)
{
    $row = $resultCount->fetch_assoc();
    $totalCount = $row['total'];
    $totalCountNext = $totalCount + 1;
    // echo "totalCount:" . $totalCount ."<br>";
    // echo "totalCountNext:" . $totalCountNext ."<br>";
    $varlentotal = strlen($totalCount);
    // echo "varlentotal: " . $varlentotal . "<br>";
    if ($varlentotal == 1) {
        $varnextnoorder = "000". $totalCountNext;
        // echo "varnextnoorder 000: ".$varnextnoorder."<br>";
    }elseif($varlentotal == 2) {
        $varnextnoorder = "00" . $totalCountNext;
        // echo "varnextnoorder 00: ".$varnextnoorder."<br>";
    }elseif($varlentotal == 3) {
        $varnextnoorder = "0" . $totalCountNext;
        // echo "varnextnoorder 0: ".$varnextnoorder."<br>";
    }elseif($varlentotal == 4) {
        $varnextnoorder = $totalCountNext;
        // echo "varnextnoorder NULL: ".$varnextnoorder."<br>";
    }
}

// echo "<br>kolom2dok: " . $kolom2dok . " - " . $un ."<br>";
$sqldok = "SELECT * FROM $namatabledbdok WHERE $kolom2dok = '$un'";
// echo $sqldok . "<br>";
$resultdok = mysqli_query($conn, $sqldok);
if ($resultdok->num_rows > 0) {
    while ($rowdok = $resultdok->fetch_assoc()) {
        $kolom1dokx = $rowdok[$kolom1dok];
        // echo "<br>kolom1dokx: " . $kolom1dokx."<br>";
    }
}

$val1b = 'PL'.date('Ymd').$varnextnoorder;
// echo "varnextnoorder: " . $val1b . "<br>";
$sql = "SELECT * FROM $namatabledb WHERE $kolom2 = '$id' AND $kolom3 = '$val3'";
$result = mysqli_query($conn, $sql);
//if (mysqli_num_rows($result) > 0) {
if ($result->num_rows > 0) {
    // echo "Nomor Rawat $id dan Tanggal Permintaan $val3 sudah ada dalam tabel.";
    while ($row = $result->fetch_assoc()) {
        $statusnoorder = 1;
        $varnoorderx = $row[$kolom1];
        // echo "<br>kolom1:" . $varnoorderx."<br>";
    }
} else {
    $statusnoorder = 0;
    $currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    // echo "<br>URL lengkap dengan parameter: $currentUrl <br>";
    // echo "<br>Refresh dulu sekali (sudah otomatis) menggunakan : $currentUrl <br>";
    echo "<br>Halaman ini akan melakukan refresh otomatis dalam 3 detik, dan tulisan ini akan hilang : $currentUrl <br>";
    echo "<meta http-equiv='refresh' content='3'>";

    // echo "Nomor Rawat $id dan Tanggal Permintaan $val3 tidak ditemukan dalam tabel, dan baru saja dibuatkan.<br>";
    $sql = "INSERT INTO $namatabledb ($kolom1, $kolom2, $kolom3, $kolom4, $kolom5, $kolom6, $kolom7, $kolom8, $kolom9, $kolom10, $kolom11, $kolom12) 
            VALUES                   ('$val1b', '$val2', '$val3', '$val4', '$val5', '$val6', '$val7', '$val8', '$kolom1dokx', '$val10', '$val11', '$val12')";
    if (mysqli_query($conn, $sql)) {
        // echo "Data berhasil ditambahkan.<br>";
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    // mysqli_close($conn);
}

// echo "Link saat ini: " . $currentURL . "<br>";;

if($vargetkdjenisprw != NULL){
    // echo "vargetkdjenisprw:" . $vargetkdjenisprw. "<br>";
}

// echo "<br>statusnoorder: " .$statusnoorder . "<br>";
// echo "<br>";
// if($statusnoorder == 1){
//     echo "Tampilkan list jenis perawatan";
// }


// $sqljpl = "SELECT * FROM $namatabledbjnpl WHERE status = '1'";
// $resultjpl = $conn->query($sqljpl);
// if ($resultjpl->num_rows > 0) {
//     echo "<form action='items.php' method='POST'>";
//     echo "<label for='jnsprwatan'>Pilih Data:</label>";
//     echo "<select name='jnsprwatan' id='jnsprwatan'>";
//     while ($row = $resultjpl->fetch_assoc()) {
//         echo "<option value='" . $row["kd_jenis_prw"] . "'>" . $row["kd_jenis_prw"] . " - " . $row["nm_perawatan"] . "</option>";
//     }
//     echo "</select>";
//     echo "<input type='submit' value='Submit'>";
//     echo "</form>";
// } else {
//     echo "Tidak ada data ditemukan.";
// }



// $sql = "INSERT INTO permintaan_lab ($kolom1, $kolom2, $kolom3, $kolom4, $kolom5, $kolom6, $kolom7, $kolom8, $kolom9, $kolom10, $kolom11, $kolom12) 
//         VALUES                     ('$val1', '$val2', '$val3', '$val4', '$val5', '$val6', '$val7', '$val8', '$val9', '$val10', '$val11', '$val12')";
// if (mysqli_query($conn, $sql)) {
//     echo "Data berhasil ditambahkan.";
// } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }
// mysqli_close($conn);
?>

    <!-- Formulir pencarian dan checkbox -->
    <form action="" method="POST">
    <div class="container">
        <span id="resulttextnoorder" style="display: none;"><label for="NoOrder">Nomor Order: </label><input type="text" id="textnoorder" name="textnoorder" value="<?php echo $varnoorderx; ?>"> (Refresh dulu halaman ini jika nomor order masih kosong)</span>
        <label for="search">Cari Sample Pemeriksaan:</label>
        <input type="text" id="search" name="search" autocomplete="off">
        <div id="searchResults"></div>

        <!-- Checkbox untuk hasil pencarian -->
        <div id="checkboxContainer"></div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
        <!-- <input type="submit" value="Simpan"> -->
    </form>
    <!-- Skrip JavaScript -->
    <script>
        $(document).ready(function() {
            // Menggunakan event input untuk mendeteksi perubahan pada input
            $('#search').on('input', function() {
                var searchQuery = $(this).val();

                // Kirim permintaan AJAX ke server untuk mendapatkan rekomendasi
                $.ajax({
                    url: 'get_rekomendasi.php',
                    method: 'POST',
                    data: { searchQuery: searchQuery },
                    success: function(response) {
                        // Tampilkan hasil rekomendasi sebagai checkbox
                        $('#checkboxContainer').html(response);
                    }
                });
            });
        });
    </script>

</body>
</html>
<?php
mysqli_close($conn);
?>