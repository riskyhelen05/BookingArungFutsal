# ⚽ Arung Futsal Booking System

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38BDF8)
![Status](https://img.shields.io/badge/Status-Development-success)

Sistem informasi pemesanan lapangan futsal berbasis web yang dikembangkan untuk membantu proses reservasi lapangan, pengelolaan jadwal, verifikasi pembayaran, serta monitoring aktivitas booking secara lebih efektif.

---

## 📌 Tentang Proyek

Arung Futsal Booking System merupakan aplikasi berbasis web yang dirancang untuk mempermudah pelanggan dalam melakukan pemesanan lapangan futsal secara online serta membantu pihak pengelola dalam mengelola operasional lapangan secara lebih efektif.

Sistem menyediakan fitur booking, pembayaran, QR check-in, notifikasi, ulasan pengguna, pengelolaan jadwal, blokir jadwal, hingga laporan statistik yang dapat diekspor ke berbagai format.

---

## 🚀 Teknologi yang Digunakan

### Backend

* Laravel
* PHP
* MySQL

### Frontend

* Blade Template Engine
* Tailwind CSS
* JavaScript
* Chart.js

### Tools

* Composer
* Laravel Artisan
* Git & GitHub
* XAMPP / Laragon

---

# 👤 Fitur Pengguna

### 🔐 Authentication

* Splash Screen
* Registrasi akun
* Login pengguna
* Logout

### 🏠 Dashboard User

* Informasi booking mendatang
* Statistik booking pengguna
* Pengingat jadwal bermain

### 📅 Booking Lapangan

* Pemilihan lapangan
* Pemilihan tanggal dan jam bermain
* Validasi slot tersedia
* Preview booking
* Upload bukti pembayaran

### 📖 Riwayat Booking

* Booking aktif
* Riwayat booking selesai
* Detail booking

### 🎫 Tiket Digital

* QR Code booking
* Download tiket QR dalam format PNG

### ❌ Pembatalan Booking

* Form pembatalan booking
* Halaman konfirmasi pembatalan

### ⭐ Review Lapangan

* Pemberian rating
* Penulisan ulasan setelah bermain

### 🔔 Notifikasi

* Konfirmasi booking
* Penolakan pembayaran
* Pembatalan booking
* Reminder jadwal bermain
* Informasi check-in berhasil
* Detail notifikasi

### 👤 Profil

---

# 👨‍💼 Fitur Administrator

### 📊 Dashboard Admin

* Monitoring booking
* Statistik status booking

### 💳 Verifikasi Pembayaran

* Konfirmasi pembayaran
* Penolakan pembayaran beserta alasan

### 📱 Scanner QR

* Pemindaian QR booking
* Validasi tiket
* Konfirmasi kehadiran (check-in)

### 🗓️ Kelola Jadwal

* Tampilan slot lapangan
* Integrasi status booking

### 🚫 Blokir Jadwal

* Pemilihan lapangan dan tanggal
* Pemilihan slot blokir
* Review blokir jadwal
* Konfirmasi blokir jadwal
* Statistik blokir
* Pembatalan blokir jadwal

### 📈 Modul Laporan

* Filter berdasarkan periode
* Total booking
* Booking berhasil
* Total pendapatan
* Slot terisi
* Slot tersedia
* Grafik pendapatan
* Grafik status booking
* Tabel booking terbaru
* Export PDF
* Export Excel
* Export CSV

### ⚙️ Kelola Lapangan

* Melakukan CRUD Kelola Lapangan

### 👤 Profil Admin

---

# 🔒 Implementasi ACID Transaction

Sistem menerapkan prinsip **ACID (Atomicity, Consistency, Isolation, Durability)** untuk menjaga integritas data pada proses penting.

Implementasi dilakukan pada:

* Pemesanan booking lapangan.
* Verifikasi pembayaran.
* Penolakan pembayaran.
* Pembatalan booking oleh pengguna.
* Check-in QR oleh administrator.

---

# 📋 Status Booking

| Status               | Keterangan                          |
| -------------------- | ----------------------------------- |
| Pending              | Booking berhasil dibuat             |
| Waiting Confirmation | Menunggu verifikasi pembayaran      |
| Confirmed            | Booking telah dikonfirmasi          |
| Cancelled            | Booking dibatalkan                  |
| Completed            | Booking selesai / check-in berhasil |

---

# 🛠️ Instalasi

Clone repository:

```bash
git clone https://github.com/riskyhelen05/BookingArungFutsal.git
```

Masuk ke folder proyek:

```bash
cd BookingArungFutsal
```

Install dependency:

```bash
composer install
npm install
```

Salin file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Konfigurasi database pada file `.env`.

Jalankan migrasi:

```bash
php artisan migrate
```

Jalankan server:

```bash
php artisan serve
npm run dev
```

Akses aplikasi melalui:

```text
http://127.0.0.1:8000
```

---

# 📚 Tujuan Pengembangan

Sistem ini dikembangkan sebagai bagian dari proyek akademik untuk menerapkan konsep:

* Pengembangan aplikasi web menggunakan Laravel.
* Manajemen basis data relasional.
* Implementasi transaksi ACID.
* Penerapan autentikasi dan otorisasi pengguna.
* Integrasi QR Code.
* Visualisasi data dan pelaporan.

---

# 👥 Tim Pengembang Kelompok 13

### Helen Risky Dwi Wahyuni (24082010054)

### Andrey Parinding (24082010076)

### Muhammad Yahya Zahid (24082010086)

---

# 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademik dan pembelajaran.
