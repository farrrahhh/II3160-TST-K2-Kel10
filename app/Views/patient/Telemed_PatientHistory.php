<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle) ?></title>
</head>
<body>
    <h1>Riwayat Gejala</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <?php if (empty($history)): ?>
        <p>Belum ada data riwayat gejala yang tersimpan.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Keluhan</th>
                    <th>Usia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($item['nama']) ?></td>
                        <td><?= esc($item['keluhan_penyakit']) ?></td>
                        <td><?= esc($item['usia']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="/patient/dashboard">Kembali ke Dashboard</a></p>
</body>
</html>
