<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeleMedCare Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-gradient {
            background: linear-gradient(to bottom right, #EBF4FF, #F3E8FF, #FCE7F3);
        }
        .card-gradient-blue {
            background: linear-gradient(to bottom right, #3B82F6, #2563EB);
        }
        .card-gradient-purple {
            background: linear-gradient(to bottom right, #8B5CF6, #7C3AED);
        }
        .card-gradient-pink {
            background: linear-gradient(to bottom right, #EC4899, #DB2777);
        }
        .cta-gradient {
            background: linear-gradient(to right, #7C3AED, #2563EB);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient">
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold">
                <span class="text-blue-600">TeleMed</span><span class="text-purple-600">Care</span>
            </h1>
            <nav>
                <a href="<?= site_url('login') ?>" class="text-purple-600 hover:text-purple-800 mr-4">Login</a>
                <a href="<?= site_url('signup') ?>" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                    Sign Up
                </a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <section class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Dashboard Utama</h2>
            <p class="text-xl text-gray-600">Selamat datang di layanan telemedicine!</p>
        </section>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <?php
            $features = [
                ['title' => 'Konsultasi Online', 'description' => 'Konsultasikan masalah kesehatan Anda dengan dokter terpercaya secara online.', 'gradient' => 'card-gradient-blue'],
                ['title' => 'Jadwalkan Appointment', 'description' => 'Atur jadwal konsultasi Anda dengan dokter pilihan sesuai kebutuhan Anda.', 'gradient' => 'card-gradient-purple'],
                ['title' => 'Rekam Medis', 'description' => 'Akses rekam medis Anda kapan saja dan di mana saja secara aman.', 'gradient' => 'card-gradient-pink'],
            ];

            foreach ($features as $feature): ?>
                <div class="rounded-lg shadow-md p-6 text-white <?= $feature['gradient'] ?> hover:shadow-lg transition-shadow">
                    <h3 class="text-xl font-bold mb-2"><?= $feature['title'] ?></h3>
                    <p><?= $feature['description'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <section class="bg-white rounded-lg shadow-md p-8 mb-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Dokter Tersedia</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $doctors = [
                    ['name' => 'dr. Andi Pratama', 'specialty' => 'Dokter Umum'],
                    ['name' => 'dr. Siti Nurhayati, Sp.Psi.', 'specialty' => 'Psikolog'],
                    ['name' => 'dr. Budi Santoso, Sp.A.', 'specialty' => 'Dokter Anak'],
                ];

                foreach ($doctors as $doctor): ?>
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800"><?= $doctor['name'] ?></h4>
                            <p class="text-sm text-gray-600"><?= $doctor['specialty'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="cta-gradient rounded-lg shadow-md p-8 text-white text-center">
            <h3 class="text-2xl font-bold mb-4">Mulai Konsultasi Sekarang</h3>
            <p class="mb-6">Dapatkan perawatan kesehatan berkualitas dari kenyamanan rumah Anda.</p>
            <a href="<?= site_url('signup') ?>" class="bg-white text-purple-600 font-bold py-2 px-6 rounded-lg hover:bg-gray-100 transition-colors">
                Daftar Sekarang
            </a>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>Tugas Besar II3160 Teknologi Sistem Terintegrasi</p>
            <p>Created By: Clement Nathanael (18222032) & Farah Aulia (18222096)</p>
            <div class="mt-4 flex justify-center space-x-4">
                <a href="<?= site_url('about') ?>" class="hover:underline">Tentang Kami</a>
                <a href="<?= site_url('contact') ?>" class="hover:underline">Kontak</a>
                <a href="<?= site_url('privacy') ?>" class="hover:underline">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>
</body>
</html>

