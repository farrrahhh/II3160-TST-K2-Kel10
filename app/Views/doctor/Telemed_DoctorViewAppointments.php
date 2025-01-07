<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor View Appointments</title>
</head>
<body>
    <!-- print data appointsments -->
    <h1>Doctor View Appointments</h1>
    <!-- show booking_id,  'patient_id', 'dokter_id', 'booking_date', 'jam_booking'-->
    <table border="1">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Patient ID</th>
                <th>Doctor ID</th>
                <th>Booking Date</th>
                <th>Booking Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment) : ?>
                <tr>
                    <td><?= $appointment['booking_id'] ?></td>
                    <td><?= $appointment['patient_id'] ?></td>
                    <td><?= $appointment['dokter_id'] ?></td>
                    <td><?= $appointment['booking_date'] ?></td>
                    <td><?= $appointment['jam_booking'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>