# Skema database PingPong Mania

Database target: MySQL/MariaDB. Skema dibuat melalui Laravel migrations, bukan perlu mengimpor SQL manual.

## Tabel utama

- `users`: akun Laravel; migration tambahan menambah `role` dengan default `user`.
- `training_sessions`: satu baris untuk setiap sesi, terkait ke `users.id` melalui foreign key `user_id`.

## Kolom `training_sessions`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT | Primary key |
| `user_id` | BIGINT | Pemilik sesi, foreign key ke `users.id` |
| `mode` | VARCHAR(32) | `target_shooting`, `multi_ball`, `game_mode`, `custom` |
| `speed` | VARCHAR(16) | `low`, `medium`, `high` |
| `interval_seconds` | TINYINT UNSIGNED | Interval 1–30 detik |
| `direction` | VARCHAR(16) | `left`, `center`, `right`, `random` |
| `status` | VARCHAR(16) | `running`, `completed`, `stopped` |
| `started_at`, `ended_at` | TIMESTAMP nullable | Waktu mulai dan selesai |
| `duration_seconds` | INT UNSIGNED | Durasi hasil perhitungan saat STOP diterima |
| `score` | TINYINT UNSIGNED nullable | Skor opsional; belum dihitung otomatis |
| `created_at`, `updated_at` | TIMESTAMP | Timestamp Laravel |

Index disiapkan pada `(user_id, status)` dan `(user_id, created_at)` untuk membantu dashboard/riwayat. Saat akun dihapus, sesi terkait ikut dihapus.

## Migrasi

```cmd
php artisan migrate
```

Backup database sebelum menjalankan migrasi di database yang sudah berisi data. Migration template restoran tetap berada di folder migrasi agar project lama dapat dibuat dari awal, tetapi route lama restoran sudah dilepas dari `routes/web.php`.
