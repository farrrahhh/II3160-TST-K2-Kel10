<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Konsultasi</title>
</head>
<body>
    <h1>Tambah Jadwal Konsultasi</h1>

    <!-- Menampilkan pesan error jika ada -->
    <?php if (session()->getFlashdata('errors')): ?>
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/doctor/add-schedule" method="post">
    <?= csrf_field() ?>

    <label for="jadwal_konsultasi">Jadwal Konsultasi:</label>
    <input type="date" name="jadwal_konsultasi" id="jadwal_konsultasi" required>
    <br>

    <label for="jam">Jam Konsultasi:</label>
    <input type="time" name="jam" id="jam" required>
    <br>

    <button type="submit">Tambah Jadwal</button>
</form>

</body>
</html>
