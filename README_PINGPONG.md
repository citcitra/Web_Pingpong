# PingPong Mania — panduan implementasi

Project ini merupakan rombakan awal dari template Laravel restoran menjadi dashboard kontrol latihan pingpong. Target kompatibilitas saat ini tetap Laravel 5.8 agar perubahan lebih kecil. Karena Laravel 5.8 sudah lama dan tidak cocok dengan PHP modern, jangan menjalankannya memakai PHP 8.2/8.4.

## 1. Persiapan lingkungan

- Untuk menjalankan versi Laravel 5.8 yang ada, gunakan lingkungan PHP 7.4 yang terpisah dan cocokkan extension di `php.ini` (`openssl`, `pdo_mysql`, `mbstring`, `fileinfo`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath` jika diperlukan).
- PHP 7.4 juga sudah tidak mendapat dukungan keamanan. Ini hanya pilihan kompatibilitas sementara untuk pengembangan lokal; sebelum dipublikasikan, rencanakan upgrade ke versi Laravel/PHP yang masih didukung.
- Jangan mengedit file di `vendor/` untuk menutupi deprecation PHP. Perubahan vendor mudah hilang dan tidak menyelesaikan akar masalah.

## 2. Instalasi di Windows

1. Ekstrak project ke folder kerja, misalnya `C:\Users\<username>\Laravel-Restoran`.
2. Salin `.env.example` menjadi `.env`. Jangan unggah `.env` ke repositori atau membagikan isinya.
3. Buat database MySQL bernama `pingpong_mania` lewat phpMyAdmin.
4. Sesuaikan DB_USERNAME/DB_PASSWORD di `.env`.
5. Dari CMD, pastikan executable PHP kompatibel berada di PATH atau gunakan path lengkap:
   - `php -v` (harus menunjukkan PHP 7.4.x untuk stack lama ini)
   - `composer install`
   - `php artisan key:generate`
   - `php artisan config:clear`
   - `php artisan migrate`
   - `php artisan serve`
6. Buka `http://127.0.0.1:8000`, daftar akun, lalu masuk ke dashboard.

Jika project pernah memakai database restoran, backup database terlebih dahulu. Migration baru menambahkan tabel latihan dan kolom role; migration lama template masih ada, tetapi route restoran tidak lagi dipakai dari `routes/web.php`.

## 3. Integrasi Raspberry Pi

1. Sambungkan server Laravel dan Raspberry Pi ke jaringan lokal yang sama.
2. Tentukan IP Raspberry Pi dan isi `RASPBERRY_PI_URL=http://IP_RASPBERRY:5000` di `.env`.
3. Buat token rahasia panjang dengan `python -c "import secrets; print(secrets.token_urlsafe(48))"`. Isi ke `RASPBERRY_PI_TOKEN` di Laravel dan `PINGPONG_API_TOKEN` di Raspberry Pi. Jangan masukkan token ke JavaScript, view, atau Git.
4. Ikuti `raspberry/README.md`. Service Raspberry Pi yang disertakan masih **kerangka**: belum menggerakkan motor karena jenis Pi, motor, dan driver belum teridentifikasi. `driver_adapter.py` harus diimplementasikan dan diuji terlebih dahulu.
5. Setelah menyimpan `.env`, jalankan `php artisan config:clear`.
6. API Laravel akan meneruskan perintah ke `POST /api/control`; jika Pi tidak tersedia atau belum menerima perintah, UI akan menampilkan error. Respons sukses hanya berarti API Pi menerima perintah, bukan bukti fisik bola benar-benar terlontar.

## 4. Fitur yang dibuat

- Landing page PingPong Mania.
- Redirect login/register ke dashboard.
- Dashboard statistik dan kontrol mode, kecepatan, interval, serta arah.
- Riwayat sesi tersimpan per pengguna dan filter tanggal/mode.
- Profil dan ganti password dengan verifikasi password lama.
- Kontrol mesin hanya tersedia untuk pengguna login, dilindungi CSRF dan validasi server. START/CONFIGURE dibatasi rate-limit; STOP memiliki endpoint terpisah agar tidak terhalang limit START/CONFIGURE.
- Komunikasi backend ke Raspberry Pi memakai bearer token dari environment.

## 5. Keamanan dan batasan

- Jangan expose API Raspberry Pi langsung ke internet; batasi firewall ke server Laravel dan gunakan jaringan terisolasi. HTTP bearer token di LAN tidak terenkripsi; untuk jaringan yang tidak sepenuhnya tepercaya gunakan HTTPS/VPN.
- Gunakan emergency stop fisik, interlock, watchdog timeout, dan default motor OFF. Tombol STOP web tidak dapat menjamin berhenti bila jaringan/perangkat mati.
- Admin role ditambahkan pada schema untuk pengembangan berikutnya, tetapi halaman admin belum dibuat.
- Skor belum diukur otomatis; kolom skor disediakan untuk integrasi sensor/evaluasi berikutnya.
- Setelah deployment, set `APP_DEBUG=false`, HTTPS, secret unik, backup database, dan update framework ke versi yang didukung.
