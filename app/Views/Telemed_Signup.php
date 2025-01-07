<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <h1>Signup</h1>
    <form action="/signup" method="post">
        <?= csrf_field() ?>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="patient">Patient</option>
            <option value="doctor">Doctor</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
