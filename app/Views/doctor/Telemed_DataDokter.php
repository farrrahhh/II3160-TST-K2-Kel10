<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Dokter</title>
</head>
<body>
    <h1>Pendaftaran Dokter</h1>

    <form action="/doctor/save" method="post">
        <?= csrf_field() ?>

        <label for="nama_dokter">Nama Dokter:</label>
        <input type="text" name="nama_dokter" required><br>

        <label for="spesialis">Spesialis:</label>
        <input type="text" name="spesialis" required><br>

        <button type="submit">Simpan Data</button>
    </form>
</body>
</html>
