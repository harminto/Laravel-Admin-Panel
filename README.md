# Laravel Admin Panel
Aplikasi Laravel Admin Panel yang telah dipersiapkan dengan modul dasar untuk manajemen pengguna, peran, menu, dan pengaturan aplikasi. Sangat cocok untuk pengembangan aplikasi web dengan fitur backend yang kuat dan mudah diperluas.

## Cara Menggunakan
1. Pastikan Anda telah menginstal PHP dan Composer di sistem Anda.
2. Clone repositori ini ke dalam sistem Anda:
    ```bash
    git clone https://github.com/harminto/Laravel-Admin-Panel.git
    ```
3. Buka terminal dan navigasikan ke direktori proyek:
    ```bash
    cd Laravel-Admin-Panel
    ```
4. Instal dependensi PHP menggunakan Composer:
    ```bash
    composer install
    ```
5. Generate kunci aplikasi:
    ```bash
    php artisan key:generate
    ```
6. Setelah migrasi selesai, jalankan aplikasi dengan menggunakan perintah:
    ```bash
    php artisan serve
    ```
7. Buka browser web Anda dan kunjungi alamat http://localhost:8000 untuk mengakses aplikasi.
8. Jika ini adalah pertama kalinya Anda memanggil aplikasi, Anda akan diarahkan ke halaman instalasi. Aplikasi akan meminta Anda untuk melakukan instalasi dan konfigurasi database.

   Jika Anda mengalami kesalahan saat instalasi, jalankan perintah berikut di terminal Anda:
    ```bash
    php artisan migrate
    ```
    ```bash
    php artisan db:seed
    ```
   Ini akan menjalankan migrasi database dan seeding data awal jika diperlukan.

## Informasi Tambahan

### Masuk ke Aplikasi
Setelah berhasil melakukan instalasi, Anda dapat masuk ke dalam aplikasi menggunakan akun berikut:
- **Username:** admin@example.com
- **Password:** password

### Menambahkan Modul Baru
Jika Anda ingin menambahkan modul baru ke dalam aplikasi, ikuti langkah-langkah berikut:

1. **Buat Migrasi**: Pertama, buat migrasi untuk mengatur skema basis data baru yang diperlukan oleh modul Anda.
   ```bash
   php artisan make:migration create_nama_tabel
2. **Buat Controller**: Selanjutnya, buat controller untuk menangani logika bisnis modul Anda. 
   ```bash
   php artisan make:controller NamaController
    ```
3. **Buat View**: Buat tampilan (view) untuk halaman-halaman yang terkait dengan modul Anda. 
   ```bash
   nama_file.blade.php
    ```
4. **Atur Route**: Terakhir, atur route untuk modul Anda di dalam file routes/web.php.
   ```bash
   Route::resource('nama_route', NamaController::class);
    ```
### Menambahkan Modul Baru ke Menu Backend
Untuk menampilkan modul baru yang Anda tambahkan di halaman Dashboard, ikuti langkah berikut:

1. Buka menu "Pengaturan" > "Menu Backend" dalam aplikasi.
2. Tambahkan entri baru dengan menentukan judul, URL, ikon, dan urutan sesuai dengan modul yang Anda tambahkan.
3. Atur URL sesuai dengan route yang telah Anda daftarkan untuk modul baru Anda.
