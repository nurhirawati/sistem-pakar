<!DOCTYPE html>
<html>
<head>
    <title>Hasil Diagnosa</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="result-container">
    
<?php
$gejala_terpilih = [];

if (isset($_POST['gejala']) && is_array($_POST['gejala'])) {
    foreach ($_POST['gejala'] as $gejala_id => $value) {
        $gejala_terpilih[] = intval($gejala_id);
    }
}

$id_penyakit = 0;

if (count($gejala_terpilih) > 3) {
    // Jika lebih dari tiga gejala terpilih
    $id_penyakit = 3; // Diagnosa 3
} else {
    $gejala_1_3_terpilih = count(array_intersect($gejala_terpilih, range(1, 3)));
    $gejala_4_6_terpilih = count(array_intersect($gejala_terpilih, range(4, 6)));

    if ($gejala_1_3_terpilih === 3) {
        // Jika tiga gejala dari ID Gejala 1 sampai 3 terpilih
        $id_penyakit = 1; // Diagnosa 1
    } elseif ($gejala_4_6_terpilih === 3) {
        // Jika tiga gejala dari ID Gejala 4 sampai 6 terpilih
        $id_penyakit = 2; // Diagnosa 2
    } else {
        // Jika tidak memilih ID Gejala 1 sampai 3 dan ID Gejala 4 sampai 6 secara bersamaan
        $id_penyakit = 3; // Diagnosa 3
    }
}

    // Sambungkan ke database MySQL
    $koneksi = mysqli_connect("localhost", "root", "", "pohonjatidb");
    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    
    // Query SQL untuk mendapatkan saran berdasarkan penyakit
    $sql = "SELECT penyakit.nama_penyakit, saran.keterangan_saran
            FROM saran
            INNER JOIN penyakit ON saran.id_penyakit = penyakit.id_penyakit
            WHERE penyakit.id_penyakit = $id_penyakit";
    
    $result = mysqli_query($koneksi, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $penyakit = $row['nama_penyakit'];
        $saran = $row['keterangan_saran'];
        echo "<h2>Hasil Anda - Diagnosa Penyakit Pada Pohon Jati</h2><h1>" . $penyakit . "</h1>";
        echo "<h4>Saran: " . $saran . "</h4>"; 
    } 
    
    // Tutup koneksi ke database
    mysqli_close($koneksi);
    
    ?>
    </div>
</body>
</html>
