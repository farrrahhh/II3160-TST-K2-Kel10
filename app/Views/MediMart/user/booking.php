<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Konsultasi - MediMart</title>
    <link rel="stylesheet" href="<?= base_url('css/style2.css') ?>">
    <style>
        :root {
            --primary: #8B5CF6;
            --primary-dark: #7C3AED;
            --secondary: #E5E7EB;
            --text: #1F2937;
            --text-light: #6B7280;
            --background: #F3F4F6;
        }

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

        .hero {
            background-color: #f0f4f8;
            padding: 4rem 2rem;
            text-align: center;
        }

        .hero-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hero-title {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--secondary);
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .booking-section {
            padding: 4rem 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .booking-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .booking-title {
            font-size: 1.5rem;
            color: var(--text);
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text);
            font-weight: 500;
        }

        .form-group select,
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--secondary);
            border-radius: 6px;
            font-size: 1rem;
        }

        .form-group select:focus,
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            border: none;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Book Your Consultation</h1>
                <p class="hero-subtitle">Schedule an appointment with our expert doctors for personalized care.</p>
            </div>
        </div>
    </section>

    <section class="booking-section">
        <div class="booking-card">
            <h2 class="booking-title">Booking Konsultasi</h2>
            <form id="bookingForm" action="<?= site_url('patient/booking/create') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="spesialis">Spesialis:</label>
                    <select name="spesialis" id="spesialis" required>
                        <option value="">-- Pilih Spesialis --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dokter_id">Nama Dokter:</label>
                    <select name="dokter_id" id="dokter_id" required>
                        <option value="">-- Pilih Nama Dokter --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jadwal_dokter_id">Jadwal Dokter:</label>
                    <select name="jadwal_dokter_id" id="jadwal_dokter_id" required>
                        <option value="">-- Pilih Jadwal Dokter --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="booking_date">Tanggal Booking:</label>
                    <input type="date" name="booking_date" id="booking_date" required>
                </div>
                <div class="form-group">
                    <label for="jam_booking">Jam Konsultasi:</label>
                    <select name="jam_booking" id="jam_booking" required>
                        <option value="">-- Pilih Jam --</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-primary">Buat Booking</button>
                </div>
            </form>
        </div>
    </section>

    

    <script>
        const jadwalDokter = <?= json_encode($doctors) ?>;

        const spesialisSelect = document.getElementById('spesialis');
        const dokterSelect = document.getElementById('dokter_id');
        const jadwalDokterSelect = document.getElementById('jadwal_dokter_id');
        const bookingDateInput = document.getElementById('booking_date');
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
            bookingDateInput.value = '';
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
            bookingDateInput.value = '';
            jamBookingSelect.innerHTML = '<option value="">-- Pilih Jam --</option>';

            const jadwalDokterByDokter = jadwalDokter.filter(jadwal => jadwal.dokter_id == selectedDokterId);

            jadwalDokterByDokter.forEach(jadwal => {
                const option = document.createElement('option');
                option.value = jadwal.dokter_id;
                option.textContent = jadwal.tanggal;
                option.setAttribute('data-tanggal', jadwal.tanggal);
                option.setAttribute('data-jam', jadwal.jam);
                jadwalDokterSelect.appendChild(option);
            });
        });

        jadwalDokterSelect.addEventListener('change', function () {
            const selectedOption = this.selectedOptions[0];
            const selectedTanggal = selectedOption ? selectedOption.getAttribute('data-tanggal') : '';
            const availableJam = selectedOption ? selectedOption.getAttribute('data-jam') : '';

            bookingDateInput.value = selectedTanggal;
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