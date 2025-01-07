<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pasien</title>
</head>
<body>
    <h1>Tambah Data Pasien</h1>
    <form action="/patient/save-patient" method="POST">
        <?= csrf_field() ?>

        <label for="nama">Nama Pasien:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="usia">Usia:</label><br>
        <input type="number" id="usia" name="usia" min="0" required><br><br>

        <label for="keluhan_penyakit">Keluhan Penyakit:</label><br>
        <textarea id="keluhan_penyakit" name="keluhan_penyakit" rows="4" required></textarea><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
