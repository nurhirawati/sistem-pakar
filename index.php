<!DOCTYPE html>
<html>
<head>
    <title>Hasil Diagnosa</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <main>
        <h1>SISTEM PAKAR DIAGNOSA PENYAKIT</h1>
        <h1>PADA POHON JATI</h1>
        <form action="diagnosa.php" method="post" onsubmit="return checkForm()">
            
        <?php
$koneksi = mysqli_connect("localhost", "root", "", "pohonjatidb");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

/// Ambil pertanyaan dari database
$sql_gejala = "SELECT id_gejala, nama_gejala FROM gejala";
$result_gejala = mysqli_query($koneksi, $sql_gejala);

if (mysqli_num_rows($result_gejala) > 0) {
    while ($row = mysqli_fetch_assoc($result_gejala)) {
        echo "<div style='display: flex; align-items: center; margin-bottom: 10px;'>";
        echo "<input type='checkbox' id='gejala_" . $row['id_gejala'] . "' name='gejala[" . $row['id_gejala'] . "]' value='Ya'>";
        echo "<label for='gejala_" . $row['id_gejala'] . "' style='margin-left: 5px;'>Apakah " . $row['nama_gejala'] . "?</label>";
        echo "</div>";
    }
}  
            // Tutup koneksi ke database
            mysqli_close($koneksi);
            ?>
            <br>
            <input type="submit" value="Submit">
            <br>
        </form>
    </main>
    <script>
        function checkForm() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            let isChecked = false;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    isChecked = true;
                }
            });

            if (!isChecked) {
                alert('Anda harus memilih minimal satu opsi!');
                return false; // Form tidak akan dikirim
            }

            return true; // Form akan dikirim
        }
    </script>
</body>
</html>
