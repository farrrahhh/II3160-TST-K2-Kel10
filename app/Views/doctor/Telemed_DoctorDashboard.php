<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle) ?></title>
</head>
<body>
    <h1><?= esc($pageTitle) ?></h1>
    <p><?= esc($welcomeMessage) ?></p>

    <ul>
        <li><a href="/doctor/view-appointments">View Scheduled Appointments</a></li>
        <li><a href="/doctor/add-profile">Data dokter</a></li>
        <li><a href="/doctor/add-schedule">Manage Profile</a></li>
        <li><a href="/logout">Logout</a></li>
    </ul>
</body>
</html>
