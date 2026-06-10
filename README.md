
# Company Profile - Vegetarian Paradise

## Pengenalan Project

Project ini adalah aplikasi website company profile berbasis CodeIgniter 4 yang dapat digunakan untuk menampilkan profil perusahaan, informasi produk, kontak, serta halaman utama dan tentang kami. Aplikasi ini cocok untuk landing page bisnis yang sederhana, cepat, dan mudah dikelola.

## Fitur Utama

- Halaman beranda (home)
- Halaman tentang kami (about)
- Informasi perusahaan dan kontak
- Produk unggulan yang ditampilkan dari database
- Dapat dijalankan di lingkungan lokal dengan XAMPP atau Laragon

## Persyaratan Sistem

- PHP 8.2 atau lebih tinggi
- Composer
- Apache dan MySQL
- XAMPP atau Laragon

## Instalasi di Local (XAMPP)

1. Install XAMPP lalu jalankan Apache dan MySQL.
2. Letakkan project ini di C:\\xampp\\htdocs\\company-profile.
3. Buka terminal dan jalankan: composer install
4. Salin file env menjadi .env.
5. Atur base URL di file .env menjadi http://localhost/company-profile/public/
6. Buat database MySQL dan sesuaikan setting database di .env.
7. Jalankan aplikasi dengan php spark serve atau buka http://localhost/company-profile/public/

## Instalasi di Local (Laragon)

1. Install Laragon lalu jalankan Apache dan MySQL.
2. Letakkan project ini di C:\\laragon\\www\\company-profile.
3. Buka terminal Laragon dan jalankan: composer install
4. Salin file env menjadi .env.
5. Atur base URL di file .env menjadi http://company-profile.test/
6. Buat database MySQL dan sesuaikan setting database di .env.
7. Buka browser ke http://company-profile.test/

## Catatan Penting

- Pastikan nama database, username, dan password di file .env sudah sesuai.
- Jika ada masalah pada folder writable, pastikan izin folder benar.
- Untuk pengembangan lebih lanjut, Anda dapat menjalankan php spark routes atau php spark migrate.