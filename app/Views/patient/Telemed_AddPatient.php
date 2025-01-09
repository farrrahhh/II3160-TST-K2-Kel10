<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pasien - TeleMedCare</title>
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
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Pasien</h1>

            <form action="<?= site_url('patient/save-patient') ?>" method="POST" class="space-y-6">
                <?= csrf_field() ?>

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Pasien:</label>
                    <input type="text" id="nama" name="nama" required
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>

                <div>
                    <label for="usia" class="block text-sm font-medium text-gray-700 mb-1">Usia:</label>
                    <input type="number" id="usia" name="usia" min="0" required
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>

                <div>
                    <label for="keluhan_penyakit" class="block text-sm font-medium text-gray-700 mb-1">Keluhan Penyakit:</label>
                    <textarea id="keluhan_penyakit" name="keluhan_penyakit" rows="4" required
                              class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"></textarea>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Simpan
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

