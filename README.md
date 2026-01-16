````markdown
# 💊 Apotek Shabah - Digital Pharmacy System

[![Made with PHP](https://img.shields.io/badge/Made%20with-PHP-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Database MySQL](https://img.shields.io/badge/Database-MySQL-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Styled%20with-Tailwind%20CSS-06B6D4?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Status](https://img.shields.io/badge/Status-Migrated-success)](#)

**Apotek Shabah** adalah platform kesehatan digital yang mengintegrasikan sistem manajemen informasi obat dengan layanan pelanggan. Proyek ini telah bertransformasi dari landing page statis menjadi aplikasi web dinamis berbasis **PHP** dan **MySQL** untuk memberikan pengalaman yang lebih interaktif dan terkelola.

---

## 📸 Preview Website

Berikut adalah tampilan antarmuka utama dari **Apotek Shabah**:

![Apotek Shabah Preview](https://github.com/wildan-arch/apotek_shabah/blob/main/image.png?raw=true)

---

## 🚀 Fitur Unggulan

- **Dynamic Landing Page**: Informasi obat, layanan, dan konten hero section yang dapat diperbarui secara real-time melalui database.
- **Powerful Admin Panel**: Kelola seluruh konten website (CRUD Produk & Kategori) tanpa harus menyentuh kode program secara manual.
- **WhatsApp Integration**: Tombol CTA "Hubungi Kami" dan "Konsultasi Gratis" yang terhubung langsung ke layanan pelanggan.
- **Modern UI/UX**: Antarmuka bersih menggunakan palet warna _Emerald_, font Poppins, dan desain sepenuhnya responsif dengan Tailwind CSS.
- **Fast Loading**: Performa optimal dengan struktur kode PHP yang efisien dan ringan.

---

## 🔐 Fitur Admin Panel

Halaman administrator memungkinkan pengelolaan data secara aman:

- **Dashboard**: Statistik ringkas mengenai jumlah produk dan aktivitas sistem.
- **Manajemen Produk**: Tambah, edit, dan hapus data obat (nama, harga, deskripsi, foto).
- **Manajemen Kategori**: Pengelompokan obat berdasarkan jenis (Tablet, Sirup, Alkes, dll).
- **Konfigurasi Kontak**: Pengaturan nomor WhatsApp dan informasi operasional apotek tanpa mengubah kode.

---

## 📊 Struktur Database (MySQL)

Sistem menggunakan database relasional untuk menyimpan data:

| Tabel        | Fungsi                                                        |
| :----------- | :------------------------------------------------------------ |
| `users`      | Autentikasi administrator (Username & Password Hash).         |
| `obat`       | Data katalog produk (Nama, Harga, Stok, Gambar, Kategori_ID). |
| `kategori`   | Daftar kategori obat untuk mempermudah klasifikasi.           |
| `pengaturan` | Data statis website seperti jam operasional dan kontak WA.    |

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP 8.x
- **Database**: MySQL / MariaDB
- **Frontend Stylings**: Tailwind CSS
- **Icons**: Lucide Icons & FontAwesome
- **Font**: Poppins (Google Fonts)

---

## 💻 Cara Instalasi

1.  **Clone Repositori**

    ```bash
    git clone [https://github.com/wildan-arch/apotek_shabah.git](https://github.com/wildan-arch/apotek_shabah.git)
    ```

2.  **Persiapan Database**

    - Buat database baru bernama `db_apotek` di phpMyAdmin.
    - Import file `.sql` yang terdapat di dalam folder `database/`.

3.  **Konfigurasi Koneksi**
    Sesuaikan kredensial database pada file koneksi Anda (misal: `config.php`):

    ```php
    $conn = mysqli_connect("localhost", "root", "", "db_apotek");
    ```

4.  **Jalankan Project**
    Pastikan web server (XAMPP/Laragon) aktif, lalu akses: `http://localhost/apotek_shabah`.

## 🛠️ Cara Instalasi (Lanjutan)

1.  **Impor Database**: Gunakan file `apotek_shabah.sql` yang tersedia dan impor ke MySQL Anda.
2.  **Konfigurasi Koneksi**:
    - Salin file `admin/db.php.example` menjadi `admin/db.php`.
    - Buka `admin/db.php` dan masukkan password database lokal Anda.
3.  **Akses Admin**: Buka `http://localhost/apotek_shabah/login.php` untuk masuk ke panel pengelola.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan digitalisasi layanan kesehatan. Silakan digunakan dan dikembangkan lebih lanjut secara bertanggung jawab.
````

Apakah Anda ingin saya bantu membuatkan file `.sql` untuk skema database tersebut agar folder proyek Anda lebih lengkap?
