<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>

    <!-- Tampilkan pesan sukses atau error -->
    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="/admin/update-user/<?= $user['id'] ?>" method="post">
        <?= csrf_field() ?>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?= esc($user['username']) ?>" required><br><br>

        <label for="role">Role:</label><br>
        <select id="role" name="role" required>
            <option value="patient" <?= $user['role'] == 'patient' ? 'selected' : '' ?>>Patient</option>
            <option value="doctor" <?= $user['role'] == 'doctor' ? 'selected' : '' ?>>Doctor</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select><br><br>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
