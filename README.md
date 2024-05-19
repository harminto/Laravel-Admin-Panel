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
