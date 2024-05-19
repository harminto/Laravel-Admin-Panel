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
            <form action="{{ route('pendaftaran-esport') }}" method="POST" enctype="multipart/form-data" id="formPendaftaran">
                @csrf
                <input type="hidden" name="competition_types_id" value="{{ $competitionTypes->id }}">
                <div class="inputBox">
                    <input type="text" name="nama_kelompok" id="nama_kelompok" placeholder="Nama Tim/Group" required>
                    <input type="email" name="email_kelompok" id="email_kelompok" placeholder="email Group" required>
                </div>
                <div class="inputBox">
                    <p><b>Peserta/Anggota Group. Minimal 5</b></p>
                </div>
                <div class="buttonContainer">
                    <button id="tambahPesertaBtn" type="button" class="btn"><i class="fa fa-plus-circle"></i>&nbsp;Peserta</button>
                    <button id="kurangiPesertaBtn" type="button" class="btn"><i class="fa fa-minus-circle"></i>&nbsp;Peserta</button>
                </div>
                <input type="submit" value="Kirim" class="btn">
            </form>
        </div>
    </div>
</section>
<script>

// Temukan elemen tombol kurangi peserta
const kurangiPesertaBtn = document.getElementById('kurangiPesertaBtn');

// Tambahkan event listener untuk mengurangi peserta
kurangiPesertaBtn.addEventListener('click', function() {
    const inputBoxWrappers = document.querySelectorAll('.inputBoxWrapper');
    
    // Pastikan ada setidaknya satu peserta yang bisa dikurangi
    if (inputBoxWrappers.length > 1) {
        // Hapus elemen div peserta terakhir
        const lastInputBoxWrapper = inputBoxWrappers[inputBoxWrappers.length - 1];
        lastInputBoxWrapper.remove();
    } else {
        // Jika hanya satu peserta, tampilkan pesan bahwa tidak bisa dikurangi lagi
        alert('Minimal 1 peserta dalam kelompok!');
    }
});

// Temukan elemen tombol tambah peserta
const tambahPesertaBtn = document.getElementById('tambahPesertaBtn');

// Tambahkan event listener ketika tombol diklik
let jumlahPeserta = 0;

tambahPesertaBtn.addEventListener('click', function() {
    jumlahPeserta++;
    // Buat elemen input untuk detil peserta
    const inputDetilPeserta = `
        <div class="inputBox">
            <p>Peserta ke-${jumlahPeserta}</p>
        </div>
        <div class="inputBox">
            <input type="text" name="nama_peserta[]" placeholder="Nama Peserta" required>
            <input type="text" name="no_wa[]" placeholder="Nomor WA" required>
        </div>
        <div class="inputBox">
            <input type="text" name="nickname[]" placeholder="Nickname" required>
            <input type="text" name="asal_sekolah[]" placeholder="Asal Sekolah" required>
        </div>
        <div class="inputBox">
            <input type="file" name="kartu_pelajar[]" required>
            <label for="kartu_pelajar[]">Unggah Kartu Pelajar (PDF/JPG/PNG)</label>
        </div>
        <div class="inputBox">
            
        </div>
    `;

    // Buat elemen div baru untuk input detil peserta
    const div = document.createElement('div');
    div.classList.add('inputBoxWrapper');
    div.innerHTML = inputDetilPeserta;

    // Temukan form dan tambahkan input detil peserta ke dalamnya
    const form = document.querySelector('.box form');
    form.insertBefore(div, tambahPesertaBtn.parentNode);
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formPendaftaran');
    const notification = document.createElement('div');
    notification.classList.add('notification');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Validasi jumlah peserta
        const jumlahPesertaInputBoxes = document.querySelectorAll('.inputBoxWrapper').length;
        if (jumlahPesertaInputBoxes < 1) {
            notification.textContent = 'Satu Group Minimal beranggotakan 5 peserta!';
            notification.classList.add('error');
            form.appendChild(notification);
            
            // Hilangkan pesan error setelah beberapa detik (misal: 5 detik)
            setTimeout(function() {
                notification.classList.remove('error');
                notification.textContent = '';
            }, 5000); // Waktu dalam milidetik (misal: 5000ms = 5 detik)

            return; // Stop pengiriman data jika jumlah peserta kurang dari 5
        }

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
            }, 3000); // Waktu dalam milidetik (misal: 3000ms = 3 detik)
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