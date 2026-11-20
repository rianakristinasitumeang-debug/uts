# Rumah Anyam

**Katalog inventaris studio kerajinan Nusantara berbasis PHP MVC dan SQLite.** Rumah Anyam adalah toko fiktif yang mengkurasi benda pakai buatan pengrajin lokal: anyaman, keramik, tekstil, furnitur, dan dekorasi.

## Identitas

- Nama: **[RIANA KRISTINA SITUMEANG]**
- NIM: **[25210019]**
- Kelas: **[KOMPUTERISASI AKUNTANSI]**
- Mata kuliah: **[PEMOGRAMAN WEB II]**

> Ganti bagian dalam tanda kurung siku dengan identitasmu sebelum mengumpulkan proyek.

## Fitur

- CRUD produk: tambah, lihat, ubah, dan hapus.
- Pencarian produk dan filter berdasarkan kategori.
- Ringkasan inventaris: jumlah produk, kategori, unit tersedia, dan stok rendah.
- Validasi data, prepared statements, token CSRF untuk aksi tulis, dan konfirmasi sebelum menghapus.
- Database SQLite dibuat otomatis dari `database/schema.sql` pada kunjungan pertama.
- Formulir dengan pratinjau gambar, tata letak responsif, serta data awal yang sesuai dengan tema toko.

## Teknologi

- PHP 8.1 atau lebih baru
- PDO SQLite (`pdo_sqlite`)
- HTML, CSS, dan JavaScript tanpa dependensi frontend

## Menjalankan aplikasi

1. Pastikan PHP CLI tersedia dan ekstensi `pdo_sqlite` aktif.
2. Buka terminal di folder proyek.
3. Jalankan server pengembangan PHP:

   ```powershell
   php -S 127.0.0.1:8000 -t public
   ```

4. Buka `http://127.0.0.1:8000` di browser.
5. File `storage/rumah-anyam.sqlite` akan dibuat otomatis saat aplikasi pertama kali dibuka dan langsung berisi data contoh.

Untuk membuat ulang database dari awal, hentikan server, hapus `storage/rumah-anyam.sqlite`, lalu buka aplikasi kembali. Perubahan data tersimpan di SQLite tersebut.

## Struktur folder

```text
rumah-anyam/
├── app/
│   ├── Controllers/
│   │   └── ProductController.php
│   ├── Core/
│   │   └── Database.php
│   ├── Models/
│   │   └── Product.php
│   ├── Support/
│   │   └── helpers.php
│   └── Views/
│       ├── catalog/
│       │   ├── form.php
│       │   └── index.php
│       ├── errors/
│       │   └── message.php
│       └── layout.php
├── database/
│   └── schema.sql
├── public/
│   ├── assets/
│   │   ├── app.css
│   │   └── app.js
│   └── index.php
├── storage/
│   └── rumah-anyam.sqlite  (dibuat otomatis)
└── README.md
```

## Skema database

Tabel `products` menyimpan kode, nama, kategori, deskripsi, harga dalam rupiah, stok, URL foto, dan waktu pencatatan. Skema sekaligus menyisipkan delapan data contoh yang bisa langsung dikelola melalui antarmuka. Lihat [`database/schema.sql`](database/schema.sql).

## Catatan aset

Foto produk menggunakan URL gambar dari Unsplash dan memerlukan koneksi internet. Seluruh nama toko, produk, stok, dan harga dalam proyek ini adalah data fiktif untuk keperluan demonstrasi.
