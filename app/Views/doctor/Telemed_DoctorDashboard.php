<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle) ?> - TeleMedCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-gradient {
            background: linear-gradient(to bottom right, #EBF4FF, #F3E8FF, #FCE7F3);
        }
    </style>
</head>
<body class="bg-gradient min-h-screen flex flex-col">
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold">
                <span class="text-blue-600">TeleMed</span><span class="text-purple-600">Care</span>
            </h1>
            <nav>
                <a href="<?= site_url('logout') ?>" class="text-purple-600 hover:text-purple-800 font-semibold">Logout</a>
            </nav>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-4"><?= esc($pageTitle) ?></h1>
            <p class="text-gray-600 mb-6"><?= esc($welcomeMessage) ?></p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="<?= site_url('doctor/view-appointments') ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800">View Scheduled Appointments</h3>
                </div>
                <p class="text-gray-600">Check your upcoming appointments and patient details</p>
            </a>

            <a href="<?= site_url('doctor/add-profile') ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800">Data Dokter</h3>
                </div>
                <p class="text-gray-600">View and update your professional information</p>
            </a>

            <a href="<?= site_url('doctor/add-schedule') ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800">Manage Profile</h3>
                </div>
                <p class="text-gray-600">Update your availability and consultation hours</p>
            </a>

            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800">Quick Stats</h3>
                </div>
                <ul class="text-gray-600">
                    <li>Appointments Today: 5</li>
                    <li>Pending Consultations: 3</li>
                    <li>Total Patients: 120</li>
                </ul>
            </div> -->
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>© 2023 TeleMedCare. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</body>
</html>

