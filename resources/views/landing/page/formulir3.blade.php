<style>
.buttonContainer {
    display: flex;
    gap: 10px;
}
#tambahPesertaBtn {
    background-color: #4CAF50;
}

/* Style untuk tombol kurangi peserta */
#kurangiPesertaBtn {
    background-color: #f44336;
}

</style>
<section class="formulir" id="formulir">
    <h1 class="heading"><span>Daftar Sebagai</span> Peserta</h1>
    <div class="box-container">
        <div class="box">
            <form action="{{ route('pendaftaran-bazar') }}" method="POST" enctype="multipart/form-data" id="formPendaftaran">
                @csrf
                <input type="hidden" name="competition_types_id" value="{{ $competitionTypes->id }}">
                <div class="inputBox">
                    <input type="text" name="nama_peserta" placeholder="Nama Peserta" required>
                    <input type="text" name="no_wa" placeholder="Nomor WA" required>
                </div>
                <div class="inputBox">
                    <input type="text" name="nama_usaha" placeholder="Nama Usaha" required>
                    <input type="text" name="jenis_usaha" placeholder="Jenis Usaha" required>
                </div>
                <div class="inputBox">
                    <input type="email" name="email_peserta" placeholder="Alamat Email" required>
                    @php
                    $stands_taken = \App\Models\PesertaBazar::where('competition_types_id', $competitionTypes->id)
                        ->pluck('no_stand')
                        ->toArray();
                    @endphp
                    <select name="no_stand" class="form-control">
                        @for($i = 1; $i <= 18; $i++)
                            @if(in_array($i, $stands_taken))
                                <option value="{{ $i }}" disabled>Nomor Stand {{ $i }}</option>
                            @else
                                <option value="{{ $i }}">Nomor Stand {{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <div class="inputBox">
                    <input type="file" name="kartu_identitas" required>
                    <label for="kartu_identitas">Unggah Kartu Identitas (PDF/JPG/PNG)</label>
                </div>
                <input type="submit" value="Kirim" class="btn">
            </form>
        </div>
    </div>
</section>
<script>

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formPendaftaran');
    const notification = document.createElement('div');
    notification.classList.add('notification');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Validasi setiap input
        const inputs = form.querySelectorAll('input[required], select[required]');
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
            setTimeout(function() {
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
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Terjadi kesalahan saat mengirim data.');
            }
        })
        .then(data => {
            notification.textContent = 'Data berhasil terkirim!';
            notification.classList.add('success');
            form.appendChild(notification);

            // Bersihkan atau refresh formulir setelah 3 detik
            setTimeout(function() {
                form.reset(); // Membersihkan formulir
                notification.classList.remove('success');
                notification.textContent = '';
                location.reload();
            }, 2000); // Waktu dalam milidetik (misal: 3000ms = 3 detik)
        })
        .catch(error => {
            console.error('Error:', error);
            notification.textContent = 'Terjadi kesalahan saat mengirim data.';
            notification.classList.add('error');
            form.appendChild(notification);

            // Hilangkan pesan error setelah beberapa detik (misal: 5 detik)
            setTimeout(function() {
                notification.classList.remove('error');
                notification.textContent = '';
            }, 5000); // Waktu dalam milidetik (misal: 5000ms = 5 detik)
        });
    });
});

</script>