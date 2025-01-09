<!-- File: app/Views/register.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>
<body>
    <h1>Form Registrasi</h1>

    <!-- Form registrasi -->
    <form action="/patient/registermedicine" method="post">
        <?= csrf_field() ?>

        <label for="name">Nama:</label><br>
        <input type="text" name="name" id="name" value="<?= old('name') ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value="<?= old('email') ?>" required><br><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>