<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
</head>
<body>
    <h1><?= $welcomeMessage ?></h1>
    <ul>
        <li><a href="/patient/add-patient">Tambah Data Pasien</a></li>
        <li><a href="/patient/history">Lihat History</a></li>
        <li><a href="/patient/booking">Buat Booking Konsultasi</a></li>
        <li><a href="/logout">Logout</a></li>
    </ul>
</body>
</html>
