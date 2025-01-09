<!-- <!DOCTYPE html>
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
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Dokter - TeleMedCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-gradient {
            background: linear-gradient(to bottom right, #EBF4FF, #F3E8FF, #FCE7F3);
        }
    </style>
</head>
<body class="bg-gradient min-h-screen flex flex-col">
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-3xl font-bold">
                <span class="text-blue-600">TeleMed</span><span class="text-purple-600">Care</span>
            </h1>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-md mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Pendaftaran Dokter</h1>

            <form action="<?= site_url('doctor/save') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="nama_dokter" class="block text-sm font-medium text-gray-700 mb-1">Nama Dokter:</label>
                    <input type="text" id="nama_dokter" name="nama_dokter" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label for="spesialis" class="block text-sm font-medium text-gray-700 mb-1">Spesialis:</label>
                    <input type="text" id="spesialis" name="spesialis" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>© 2023 TeleMedCare. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</body>
</html>

