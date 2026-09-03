# siKredit

Aplikasi berbasis web internal untuk mencatat, melihat, dan mengelola status pengajuan pembiayaan nasabah (Sepeda Motor, Mobil, dan Multiguna).

## Tech Stack
* **Framework:** Laravel 13
* **Language:** PHP 8.4 & Node.js 20+
* **Frontend:** Tailwind CSS & Alpine.js
* **Architecture:** Service & Repository Pattern (SOLID Principles)

## Fitur Utama & Validasi Bisnis
1. **Pencatatan Pengajuan:** Form input lengkap meliputi nama nasabah, jenis pembiayaan, nominal pengajuan, tenor, pendapatan bulanan, dan catatan.
2. **Kalkulasi Otomatis:** Sistem secara otomatis menghitung estimasi tagihan per bulan berdasarkan nominal dan tenor.
3. **Validasi & Error Handling:**
   * Pendapatan bulanan nasabah di bawah Rp 1.000.000 akan ditolak dengan pesan: *"Nasabah belum dapat mengajukan pinjaman"*.
   * Nominal maksimal pinjaman yang dapat disetujui adalah Rp 200.000.000.
   * Tenor pinjaman tertinggi adalah 24 bulan.
   * Batas maksimal pengajuan untuk satu nasabah adalah sebanyak 3 kali.
4. **Manajemen Approval:** Tabel daftar pengajuan lengkap dengan tombol aksi (Setujui, Tolak dengan dialog konfirmasi, dan Detail)[.

---

## Panduan Instalasi & Menjalankan Project

Ikuti langkah-langkah di bawah ini untuk menjalankan project di lingkungan lokal Anda:

1. Kloning Repository:
   ```bash
   git clone https://github.com/fauzannhidayat/siKredit.git
   cd siKredit
   ```

3. Install Dependensi PHP dan npm (Pastikan komputer Anda terpasang PHP 8.4, Node.js 20+ dan Composer):
   ```bash
   composer install
   npm install
   ```

5. Konfigurasi Environment (.env):
   ```bash
   cp .env.example .env
   ```
   (Sesuaikan konfigurasi database `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` pada file `.env` Anda).
   
   Rekomendasi:
   ```bash
   DB_CONNECTION=sqlite
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=nama_database_anda
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```
   (secara default project ini sudah menggunakan database.sqlite yang sudah disediakan)

7. Generate Application Key:
   ```bash
   php artisan key:generate
   ```

9. Jalankan Migrasi Database:
    ```bash
   php artisan migrate
    ```

11. Jalankan Server Lokal:
    ```bash
    php artisan serve
    npm run dev && npm run build
    ```
   (Aplikasi sekarang dapat diakses melalui browser di alamat: http://127.0.0.1:8000).
