# 🏓 PINGPONG MANIA
### Every Launch Makes You Better.

**PingPong Mania** merupakan aplikasi berbasis web yang dirancang untuk mendukung kegiatan latihan tenis meja menggunakan mesin pelontar bola pingpong otomatis. Aplikasi ini dikembangkan untuk membantu pengguna mengatur sesi latihan, mengontrol pengaturan mesin, serta memantau aktivitas latihan melalui satu platform.

---

## 📌 Tentang Proyek

PingPong Mania dikembangkan sebagai sistem pendukung latihan tenis meja dengan memanfaatkan teknologi web dan konsep otomatisasi. Sistem ini menyediakan antarmuka bagi pengguna untuk mengakses fitur latihan, sedangkan administrator memiliki akses khusus untuk mengelola pengguna dan memantau sistem.

Aplikasi ini dikembangkan menggunakan framework Laravel dan database MySQL.

## ✨ Fitur Utama

### 👤 Fitur Pengguna
- **Dashboard Pengguna** — Halaman utama untuk mengakses fitur latihan.
- **Kontrol Mesin** — Mengatur pengoperasian mesin pelontar bola pingpong.
- **Riwayat Latihan** — Melihat catatan aktivitas latihan.
- **Profil Pengguna** — Mengelola informasi akun.
- **Pengaturan Password** — Mengubah password akun.
- **Waiting List** — Bergabung dan membatalkan antrean latihan.

### 🛡️ Fitur Administrator
- **Dashboard Admin** — Menampilkan ringkasan data pengguna.
- **Manajemen Pengguna** — Melihat daftar akun yang terdaftar.
- **Pencarian Pengguna** — Mencari akun berdasarkan nama atau email.
- **Manajemen Role** — Mengubah hak akses pengguna menjadi admin atau user.

### 🔐 Sistem Keamanan dan Hak Akses
- Autentikasi login dan registrasi.
- Pembagian hak akses berdasarkan role `admin` dan `user`.
- Middleware untuk membatasi akses halaman sesuai role.
- Proteksi CSRF pada form.
- Pembatasan request pada endpoint kontrol mesin.

## 🛠️ Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| Laravel 5.8 | Backend dan framework aplikasi |
| PHP 7.4 | Bahasa pemrograman backend |
| MySQL | Database aplikasi |
| HTML | Struktur halaman web |
| CSS | Tampilan dan desain antarmuka |
| JavaScript | Interaksi pada halaman web |
| Blade Template | Template halaman Laravel |

## 📂 Struktur Proyek

```text
PingPong-Mania/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── PingPongController.php
│   │   │   └── Middleware/
│   │   └── Kernel.php
│   └── User.php
│
├── database/
│   └── migrations/
│
├── public/
│   └── asset/
│
├── resources/
│   └── views/
│       ├── admin/
│       ├── auth/
│       └── ...
│
├── routes/
│   └── web.php
│
├── .env.example
├── artisan
├── composer.json
└── README.md
```

## ⚙️ Instalasi dan Konfigurasi

Ikuti langkah berikut untuk menjalankan aplikasi di lingkungan lokal.

### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/PingPong-Mania.git
```

Masuk ke direktori proyek:

```bash
cd PingPong-Mania
```

### 2. Install Dependency

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

```bash
copy .env.example .env
```

Sesuaikan konfigurasi database pada file `.env`:

```env
APP_NAME="PingPong Mania"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pingpong_mania
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password database dengan konfigurasi MySQL yang digunakan.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Migrasi Database

Buat database dengan nama `pingpong_mania` melalui MySQL atau phpMyAdmin, kemudian jalankan:

```bash
php artisan migrate
```

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Buka aplikasi melalui browser:

```text
http://127.0.0.1:8000
```

## 👥 Hak Akses Pengguna

Aplikasi memiliki dua jenis role dengan hak akses yang berbeda.

| Role | Hak Akses |
|---|---|
| Admin | Dashboard admin, manajemen pengguna, pencarian akun, dan pengelolaan role. |
| User | Dashboard pengguna, kontrol mesin, riwayat latihan, profil, dan waiting list. |

Pembatasan akses dilakukan menggunakan middleware sehingga setiap role hanya dapat mengakses halaman sesuai kewenangannya.

## 🎯 Tujuan Pengembangan

Pengembangan PingPong Mania bertujuan untuk menyediakan sistem pendukung latihan tenis meja yang lebih praktis melalui integrasi aplikasi web dengan konsep mesin pelontar bola otomatis.

Dengan adanya sistem ini, diharapkan pengguna dapat melakukan latihan secara lebih terstruktur dan administrator dapat mengelola akun serta hak akses melalui satu platform.

## 👩‍💻 Pengembang

**Tim Pengembang PingPong Mania**

Proyek ini dikembangkan sebagai bagian dari kegiatan Project Base Learning

---

<p align="center">
  **PINGPONG MANIA — Every Launch Makes You Better.**
</p>