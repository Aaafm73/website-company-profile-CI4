
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

<<<<<<< HEAD
- Pastikan nama database, username, dan password di file .env sudah sesuai.
- Jika ada masalah pada folder writable, pastikan izin folder benar.
- Untuk pengembangan lebih lanjut, Anda dapat menjalankan php spark routes atau php spark migrate.
=======
This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.2 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - The end of life date for PHP 8.1 was December 31, 2025.
> - If you are still using below PHP 8.2, you should upgrade immediately.
> - The end of life date for PHP 8.2 will be December 31, 2026.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library


................................................................................................................................
>>>>>>> d325e05c596babf45cfa55d6486fc1f14501c201
