<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Form</title>
    <link rel="stylesheet" href="<?= base_url('css/style2.css') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 1.5rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #2c3e50;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #34495e;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 1rem;
        }
        .form-group textarea {
            height: 100px;
        }
        .form-group .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .form-group .checkbox-group label {
            font-weight: normal;
        }
        .btn-submit {
            display: block;
            width: 100%;
            background-color: #3498db;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #2980b9;
        }
        .margin {
            margin-top: 8rem;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="margin"></div>
    <div class="form-container">
        <h2>Medical Complaint Form</h2>
        <form action="/MediMart/submit" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" placeholder="Enter your age" min="0" required>
            </div>

            <div class="form-group">
                <label>Select Diseases</label>
                <div class="checkbox-group">
                    <!-- Checkbox group for diseases -->
                    <label><input type="checkbox" name="diseases[]" value="Diabetes"> Diabetes</label>
                    <label><input type="checkbox" name="diseases[]" value="Hypertension"> Hypertension</label>
                    <label><input type="checkbox" name="diseases[]" value="Influenza"> Influenza</label>
                    <label><input type="checkbox" name="diseases[]" value="Migraine"> Migraine</label>
                    <label><input type="checkbox" name="diseases[]" value="Maag"> Maag</label>
                    <label><input type="checkbox" name="diseases[]" value="Other"> Other</label>
                    <!-- Add other diseases -->
                </div>
            </div>

            <div class="form-group">
                <label for="complaint">Complaint</label>
                <textarea id="complaint" name="complaint" placeholder="Describe your complaint..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>
</body>
</html>
