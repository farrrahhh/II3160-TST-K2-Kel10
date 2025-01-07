<h1>Booking Konsultasi</h1>

<form action="/patient/booking/create" method="post">
    <?= csrf_field() ?>

    <!-- Dropdown Keluhan -->
    <label for="keluhan_penyakit">Keluhan:</label>
    <select name="keluhan_penyakit" id="keluhan_penyakit" required>
        <option value="">-- Pilih Keluhan --</option>
        <?php foreach ($keluhan as $k): ?>
            <option value="<?= $k['id'] ?>"><?= $k['keluhan_penyakit'] ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- Dropdown Spesialis -->
    <label for="spesialis">Spesialis:</label>
    <select name="spesialis" id="spesialis" required>
        <option value="">-- Pilih Spesialis --</option>
        <?php 
        $uniqueSpesialis = array_unique(array_map('trim', array_column($jadwalDokter, 'spesialis'))); 
        foreach ($uniqueSpesialis as $spesialis): ?>
            <option value="<?= $spesialis ?>"><?= $spesialis ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- Dropdown Nama Dokter -->
    <label for="dokter_id">Nama Dokter:</label>
    <select name="dokter_id" id="dokter_id" required>
        <option value="">-- Pilih Nama Dokter --</option>
    </select>
    <br><br>

    <!-- Dropdown Jadwal Dokter -->
    <label for="jadwal_dokter_id">Jadwal Dokter:</label>
    <select name="jadwal_dokter_id" id="jadwal_dokter_id" required>
        <option value="">-- Pilih Jadwal Dokter --</option>
    </select>
    <br><br>

    <!-- Dropdown Jam Konsultasi -->
    <label for="jam_booking">Jam Konsultasi:</label>
    <select name="jam_booking" id="jam_booking" required>
        <option value="">-- Pilih Jam --</option>
    </select>
    <br><br>

    <button type="submit">Buat Booking</button>
</form>

<script>
    const jadwalDokter = <?= json_encode($jadwalDokter) ?>;
console.log("Data jadwalDokter:", jadwalDokter);
const spesialisSelect = document.getElementById('spesialis');
const dokterSelect = document.getElementById('dokter_id');
const jadwalDokterSelect = document.getElementById('jadwal_dokter_id');
const jamBookingSelect = document.getElementById('jam_booking');

spesialisSelect.addEventListener('change', function () {
    const selectedSpesialis = this.value;

    dokterSelect.innerHTML = '<option value="">-- Pilih Nama Dokter --</option>';
    jadwalDokterSelect.innerHTML = '<option value="">-- Pilih Jadwal Dokter --</option>';
    jamBookingSelect.innerHTML = '<option value="">-- Pilih Jam --</option>';

    const dokterBySpesialis = jadwalDokter.filter(jadwal => jadwal.spesialis === selectedSpesialis);

    dokterBySpesialis.forEach(jadwal => {
        const option = document.createElement('option');
        option.value = jadwal.dokter_id; // Dokter ID sebagai value
        option.textContent = `${jadwal.dokter_id} - ${jadwal.nama_dokter}`; // Dokter ID dan Nama Dokter
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
        option.value = jadwal.id; // Pastikan ini adalah ID jadwal dokter
        option.textContent = `${jadwal.tanggal}`; // Hanya menampilkan tanggal
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
