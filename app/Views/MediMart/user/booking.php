<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Konsultasi - TeleMedCare</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(to bottom right, #EBF4FF, #F3E8FF, #FCE7F3);
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        header {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
        }
        .text-blue {
            color: #3B82F6;
        }
        .text-purple {
            color: #8B5CF6;
        }
        main {
            padding: 40px 0;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 24px;
            margin-bottom: 32px;
        }
        h2 {
            font-size: 24px;
            color: #1F2937;
            margin-bottom: 24px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 4px;
        }
        select {
            width: 100%;
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #D1D5DB;
            border-radius: 4px;
            background-color: white;
        }
        select:focus {
            outline: none;
            ring: 2px solid #8B5CF6;
            border-color: #8B5CF6;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #8B5CF6;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #7C3AED;
        }
        footer {
            background-color: #1F2937;
            color: white;
            padding: 24px 0;
            margin-top: 48px;
        }
        footer .container {
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>
                <span class="text-blue">TeleMed</span><span class="text-purple">Care</span>
            </h1>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="card">
                <h2>Booking Konsultasi</h2>
                <form id="bookingForm" action="<?= site_url('patient/booking/create') ?>" method="post">
                    <?= csrf_field() ?>
                    <div>
                        <label for="spesialis">Spesialis:</label>
                        <select name="spesialis" id="spesialis" required>
                            <option value="">-- Pilih Spesialis --</option>
                        </select>
                    </div>
                    <div>
                        <label for="dokter_id">Nama Dokter:</label>
                        <select name="dokter_id" id="dokter_id" required>
                            <option value="">-- Pilih Nama Dokter --</option>
                        </select>
                    </div>
                    <div>
                        <label for="jadwal_dokter_id">Jadwal Dokter:</label>
                        <select name="jadwal_dokter_id" id="jadwal_dokter_id" required>
                            <option value="">-- Pilih Jadwal Dokter --</option>
                        </select>
                    </div>
                    <div>
                        <label for="jam_booking">Jam Konsultasi:</label>
                        <select name="jam_booking" id="jam_booking" required>
                            <option value="">-- Pilih Jam --</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit">Buat Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>© 2023 TeleMedCare. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        const jadwalDokter = <?= json_encode($doctors) ?>;

        const spesialisSelect = document.getElementById('spesialis');
        const dokterSelect = document.getElementById('dokter_id');
        const jadwalDokterSelect = document.getElementById('jadwal_dokter_id');
        const jamBookingSelect = document.getElementById('jam_booking');

        // Populate spesialis options
        const uniqueSpesialis = [...new Set(jadwalDokter.map(jadwal => jadwal.spesialis))];
        uniqueSpesialis.forEach(spesialis => {
            const option = document.createElement('option');
            option.value = spesialis;
            option.textContent = spesialis;
            spesialisSelect.appendChild(option);
        });

        spesialisSelect.addEventListener('change', function () {
            const selectedSpesialis = this.value;

            dokterSelect.innerHTML = '<option value="">-- Pilih Nama Dokter --</option>';
            jadwalDokterSelect.innerHTML = '<option value="">-- Pilih Jadwal Dokter --</option>';
            jamBookingSelect.innerHTML = '<option value="">-- Pilih Jam --</option>';

            const dokterBySpesialis = jadwalDokter.filter(jadwal => jadwal.spesialis === selectedSpesialis);

            dokterBySpesialis.forEach(jadwal => {
                const option = document.createElement('option');
                option.value = jadwal.dokter_id;
                option.textContent = `${jadwal.dokter_id} - ${jadwal.nama_dokter}`;
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
                option.value = `${jadwal.dokter_id}|${jadwal.tanggal}|${jadwal.jam}`;
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
    </script>
</body>
</html>