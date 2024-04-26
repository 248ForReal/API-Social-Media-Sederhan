Social Media API Sederhana

Social Media API adalah proyek Laravel yang menyediakan layanan API untuk aplikasi media sosial sederhana. API ini memungkinkan pengguna untuk mendaftar, masuk, membuat postingan, menyukai postingan, dan berinteraksi dengan pengguna lainnya.

Fitur
Otentikasi pengguna: Registrasi, masuk, dan keluar.
Manajemen profil pengguna: Lihat profil, perbarui informasi, dan unggah foto profil.
Postingan: Buat, lihat, edit, dan hapus postingan.
Interaksi: Suka atau tidak suka postingan, tambahkan komentar ke postingan.
Persyaratan
PHP >= 7.4
Composer
Laravel 10.x
Laravel Passport
MySQL atau database lainnya
Postman atau alat serupa untuk menguji API
Instalasi
Clone repositori ke mesin lokal Anda.
Buka terminal dan pindah ke direktori proyek.
Jalankan composer install untuk menginstal dependensi PHP.
Salin .env.example menjadi .env dan sesuaikan konfigurasi database.
Jalankan php artisan key:generate untuk menghasilkan kunci aplikasi.
Jalankan php artisan migrate untuk menjalankan migrasi basis data.
Jalankan php artisan passport:install untuk menginstal Passport.
Jalankan php artisan serve untuk menjalankan server pengembangan.
Penggunaan
Registrasi pengguna menggunakan endpoint /register.
Masuk ke akun menggunakan endpoint /login.
Dapatkan profil pengguna dengan endpoint /users/me.
Buat postingan baru dengan endpoint /posts.
Suka atau tidak suka postingan menggunakan endpoint /posts/{post_id}/like.
Tambahkan komentar ke postingan menggunakan endpoint /posts/{post_id}/comment.
Kontribusi
Kami mengundang kontribusi dari komunitas! Silakan laporkan bug, ajukan fitur baru, atau kirimkan pull request. Lihat CONTRIBUTING.md untuk panduan kontribusi.

Lisensi
Proyek ini dilisensikan di bawah MIT License.
