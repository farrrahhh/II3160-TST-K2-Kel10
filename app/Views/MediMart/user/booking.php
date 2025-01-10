<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Konsultasi - TeleMedCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-gradient {
            background: linear-gradient(to bottom right, #EBF4FF, #F3E8FF, #FCE7F3);
        }
    </style>
</head>
<body class="bg-gradient min-h-screen">
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-3xl font-bold">
                <span class="text-blue-600">TeleMed</span><span class="text-purple-600">Care</span>
            </h1>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Booking Konsultasi</h1>

            <form action="<?= site_url('/booking/createProcess') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>

               

                <div>
                    <label for="spesialis" class="block text-sm font-medium text-gray-700 mb-1">Spesialis:</label>
                    <select name="spesialis" id="spesialis" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option value="">-- Pilih Spesialis --</option>
                        <?php if (!empty($doctors)): ?>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= $doctor['id'] ?>"><?= htmlspecialchars($doctor['name']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No doctors available</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div>
                    <label for="dokter_id" class="block text-sm font-medium text-gray-700 mb-1">Nama Dokter:</label>
                    <select name="dokter_id" id="dokter_id" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option value="">-- Pilih Nama Dokter --</option>
                    </select>
                </div>

                <div>
                    <label for="jadwal_dokter_id" class="block text-sm font-medium text-gray-700 mb-1">Jadwal Dokter:</label>
                    <select name="jadwal_dokter_id" id="jadwal_dokter_id" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option value="">-- Pilih Jadwal Dokter --</option>
                    </select>
                </div>

                <div>
                    <label for="jam_booking" class="block text-sm font-medium text-gray-700 mb-1">Jam Konsultasi:</label>
                    <select name="jam_booking" id="jam_booking" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option value="">-- Pilih Jam --</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Buat Booking
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>© 2023 TeleMedCare. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const jadwalDokter = <?= json_encode($jadwalDokter) ?>;
    const spesialisSelect = document.getElementById('spesialis');
    const dokterSelect = document.getElementById('dokter_id');
    const jadwalDokterSelect = document.getElementById('jadwal_dokter_id');
    const jamBookingSelect = document.getElementById('jam_booking');
    const form = document.querySelector('form');

    spesialisSelect.addEventListener('change', function () {
        const selectedSpesialis = this.value;

        dokterSelect.innerHTML = '<option value="">-- Pilih Nama Dokter --</option>';
        jadwalDokterSelect.innerHTML = '<option value="">-- Pilih Jadwal Dokter --</option>';
        jamBookingSelect.innerHTML = '<option value="">-- Pilih Jam --</option>';

        const dokterBySpesialis = jadwalDokter.filter(jadwal => jadwal.spesialis === selectedSpesialis);

        dokterBySpesialis.forEach(jadwal => {
            const option = document.createElement('option');
            option.value = jadwal.dokter_id;
            option.textContent = jadwal.nama_dokter;
            dokterSelect.appendChild(option);
        });

        if (dokterBySpesialis.length === 0) {
            alert("Tidak ada dokter tersedia untuk spesialis ini.");
        }
    });

    dokterSelect.addEventListener('change', function () {
        const selectedDokterId = this.value;

        jadwalDokterSelect.innerHTML = '<option value="">-- Pilih Jadwal Dokter --</option>';
        jamBookingSelect.innerHTML = '<option value="">-- Pilih Jam --</option>';

        const jadwalDokterByDokter = jadwalDokter.filter(jadwal => jadwal.dokter_id == selectedDokterId);

        jadwalDokterByDokter.forEach(jadwal => {
            const option = document.createElement('option');
            option.value = jadwal.jadwal_dokter_id;
            option.textContent = jadwal.tanggal;
            option.setAttribute('data-jam', jadwal.jam);
            jadwalDokterSelect.appendChild(option);
        });
    });

    jadwalDokterSelect.addEventListener('change', function () {
        const selectedOption = this.selectedOptions[0];
        const availableJam = selectedOption ? selectedOption.getAttribute('data-jam') : '';

        jamBookingSelect.innerHTML = '<option value="">-- Pilih Jam --</option>';

        if (availableJam) {
            const option = document.createElement('option');
            option.value = availableJam;
            option.textContent = availableJam;
            jamBookingSelect.appendChild(option);
        }
    });

    form.addEventListener('submit', function (event) {
        const jadwalDokterId = jadwalDokterSelect.value;
        const dokterId = dokterSelect.value;
        const bookingDate = jadwalDokterSelect.selectedOptions[0] ? jadwalDokterSelect.selectedOptions[0].textContent : '';
        const jamBooking = jamBookingSelect.value;

        // Validate if all fields are selected
        if (!dokterId || !jadwalDokterId || !bookingDate || !jamBooking) {
            event.preventDefault();
            alert("Semua field wajib diisi!");
            return;
        }

        // Create hidden input fields
        const jadwalDokterInput = document.createElement('input');
        jadwalDokterInput.type = 'hidden';
        jadwalDokterInput.name = 'jadwal_dokter_id';
        jadwalDokterInput.value = jadwalDokterId;
        form.appendChild(jadwalDokterInput);

        const dokterIdInput = document.createElement('input');
        dokterIdInput.type = 'hidden';
        dokterIdInput.name = 'dokter_id';
        dokterIdInput.value = dokterId;
        form.appendChild(dokterIdInput);

        const bookingDateInput = document.createElement('input');
        bookingDateInput.type = 'hidden';
        bookingDateInput.name = 'booking_date';
        bookingDateInput.value = bookingDate;
        form.appendChild(bookingDateInput);

        const jamBookingInput = document.createElement('input');
        jamBookingInput.type = 'hidden';
        jamBookingInput.name = 'jam_booking';
        jamBookingInput.value = jamBooking;
        form.appendChild(jamBookingInput);
    });
});

    </script>
</body>
</html>
