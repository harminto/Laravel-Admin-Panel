<style>
#informasitambahan {
    font-size: 1.5rem;
}
.buttonContainer {
    display: flex;
    gap: 10px;
}
</style>
<section class="formulir" id="formulir">
    <h1 class="heading"><span>Pendaftaran</span> SIM Kolektif</h1>
    <div class="box-container">
        <div class="box">
        @php
            $currentDateTime = date('Y-m-d H:i');
        @endphp

        @if ($currentDateTime >= '2024-01-31 12:00')
            <!-- Tampilkan informasi yang diinginkan -->
            <h4>Maaf Pendaftaran telah ditutup, untuk informasi lebih lanjut dapat menghubungi Flayer di Atas</h4>
        @else
            <form action="{{ route('pendaftaran-sims') }}" method="POST" enctype="multipart/form-data" id="formPendaftaranSim">
                @csrf
                <input type="hidden" name="competition_types_id" value="{{ $competitionTypes->id }}">
                <div class="inputBox">
                    <input type="text" name="nomor_nik" id="nomor_nik" placeholder="Nomor NIK/KTP" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 14)">
                    <input type="text" name="nama" id="nama" placeholder="Nama Anda" required>
                </div>
                <div class="inputBox">
                    <input type="text" name="no_wa" id="no_wa" placeholder="No Whatsapp" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <select name="jenis_sim" id="jenis_sim" required>
                        <option value="">--Pilih Jenis SIM--</option>
                        <option value="A">SIM A</option>
                        <option value="C">SIM C</option>
                    </select>
                </div>
                <div class="inputBox">
                    <textarea name="alamat" id="alamat" placeholder="Alamat Anda" required></textarea>
                </div>
                <input type="submit" value="Kirim" class="btn">
            </form>
        @endif
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formPendaftaranSim');
    const notification = document.createElement('div');
    notification.classList.add('notification');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        // Validasi setiap input
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        inputs.forEach(input => {
            if (!input.value) {
                isValid = false;
                // Tambahkan penanda input yang kosong
                input.classList.add('error-input');
            } else {
                input.classList.remove('error-input');
            }
        });

        if (!isValid) {
            notification.textContent = 'Harap isi semua kolom yang diperlukan!';
            notification.classList.add('error');
            form.appendChild(notification);

            // Hilangkan pesan error setelah beberapa detik (misal: 5 detik)
            setTimeout(function () {
                notification.classList.remove('error');
                notification.textContent = '';
            }, 5000); // Waktu dalam milidetik (misal: 5000ms = 5 detik)

            return; // Stop pengiriman data jika ada input yang kosong
        }

        // Jika semua validasi berhasil, kirim data
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        if (response.status === 422) {
                            throw new Error(data.message || 'Terjadi kesalahan pada server.');
                        } else {
                            throw new Error('Terjadi kesalahan pada server. Status: ' + response.status);
                        }
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    notification.textContent = 'Data berhasil terkirim!';
                    notification.classList.add('success');
                    form.appendChild(notification);

                    // Bersihkan atau refresh formulir setelah 3 detik
                    setTimeout(function () {
                        form.reset(); // Membersihkan formulir
                        notification.classList.remove('success');
                        notification.textContent = '';
                        // Lokasi reload sesuai kebutuhan
                        // location.reload();
                    }, 2000); // Waktu dalam milidetik (misal: 3000ms = 3 detik)
                }
            })
            .catch(error => {
                console.error('Error:', error.message);
                notification.textContent = error.message;
                notification.classList.add('error');
                form.appendChild(notification);

                // Hilangkan pesan error setelah beberapa detik (misal: 5 detik)
                setTimeout(function () {
                    notification.classList.remove('error');
                    notification.textContent = '';
                }, 5000); // Waktu dalam milidetik (misal: 5000ms = 5 detik)
            });
    });
});


</script>
