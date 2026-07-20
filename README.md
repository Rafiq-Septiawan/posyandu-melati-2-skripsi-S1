# Sistem Informasi Posyandu Melati 2

Sistem informasi berbasis web untuk membantu pengelolaan data posyandu, meliputi pencatatan kesehatan ibu hamil, balita, jadwal kegiatan posyandu, dan notifikasi. Dibangun menggunakan Laravel sebagai bagian dari penelitian skripsi.

## Fitur Utama

- Manajemen data ibu hamil (data diri, riwayat pemeriksaan kehamilan)
- Manajemen data balita (data diri, riwayat pemeriksaan tumbuh kembang)
- Penjadwalan kegiatan posyandu
- Sistem notifikasi
- Manajemen multi-role pengguna (admin, bidan, kader)
- Laporan data ibu hamil & balita

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade Template, CSS, Font Awesome
- **Database:** MySQL

## Instalasi & Setup

### Prasyarat

- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM (jika menggunakan asset build)

### Langkah instalasi

```bash
# 1. Clone repository
git clone https://github.com/Rafiq-Septiawan/posyandu-melati-2-skripsi-S1.git
cd posyandu-melati-2-skripsi-S1

# 2. Install dependency PHP
composer install

# 3. Copy file environment
cp .env.example .env
php artisan key:generate

# 4. Buat database baru di MySQL, lalu sesuaikan .env
# DB_DATABASE=posyandu_melati2
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Import database
# Buka phpMyAdmin / mysql CLI, lalu import file:
# database/posyandu.sql

# 6. (Opsional) install dependency frontend
npm install
npm run dev

# 7. Jalankan server
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## Akun Demo

Gunakan akun berikut untuk mencoba sistem sesuai role masing-masing:

| Role      | Username/Email         | Password        |
| --------- | ---------------------- | --------------- |
| Ketua     | ketua@gmail.com        | ketua123        |
| Bidan     | bidan01@gmail.com      | bidan123        |
| Kader     | kader01@gmail.com      | kader123        |
| Orang Tua | silviarahayu@gmail.com | silviarahayu123 |

## 🗄️ Database

File database (beserta data dummy) tersedia di `posyandu.sql`. Import file ini ke MySQL sebelum menjalankan aplikasi.

Project ini menggunakan database hasil export (.sql), sehingga tidak perlu menjalankan php artisan migrate.
Project ini dibuat untuk keperluan skripsi/penelitian akademik.

Author

Rafiq Septiawan, S.Kom

Teknik Informatika

Universitas Muhammadiyah Tangerang
