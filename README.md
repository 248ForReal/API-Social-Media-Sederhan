# Social Media API

Social Media API adalah proyek Laravel yang menyediakan layanan API untuk aplikasi media sosial sederhana. API ini memungkinkan pengguna untuk mendaftar, masuk, membuat postingan, menyukai postingan, dan berinteraksi dengan pengguna lainnya.

## Fitur

- **Otentikasi Pengguna:** Registrasi, masuk, dan keluar.
- **Manajemen Profil Pengguna:** Lihat profil, perbarui informasi, dan unggah foto profil.
- **Postingan:** Buat, lihat, edit, dan hapus postingan.
- **Interaksi:** Suka atau tidak suka postingan, tambahkan komentar ke postingan.

## Persyaratan

- PHP >= 7.4
- Composer
- Laravel 10.x
- Laravel Passport
- MySQL atau database lainnya
- Postman atau alat serupa untuk menguji API

## Instalasi

1. Clone repositori ke mesin lokal Anda.
2. Buka terminal dan pindah ke direktori proyek.
3. Jalankan `composer install` untuk menginstal dependensi PHP.
4. Salin `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.
5. Jalankan `php artisan key:generate` untuk menghasilkan kunci aplikasi.
6. Jalankan `php artisan migrate` untuk menjalankan migrasi basis data.
7. Jalankan `php artisan passport:install` untuk menginstal Passport.
8. Jalankan `php artisan storage:link ` untuk menginstal Passport.
9. Jalankan `php artisan serve` untuk menjalankan server pengembangan.

## Penggunaan

### Pengguna (Users)

1. Registrasi pengguna menggunakan endpoint `/register`.
2. Masuk ke akun menggunakan endpoint `/login`.
3. Dapatkan profil pengguna dengan endpoint `/users/me`.
4. Perbarui informasi profil pengguna dengan endpoint `/users/{user_id}`.
5. Ikuti atau berhenti mengikuti pengguna lain dengan endpoint `/users/{user_id}/follow`.
6. Dapatkan daftar pengikut dengan endpoint `/users/{user_id}/followers`.
7. Dapatkan daftar yang diikuti oleh pengguna dengan endpoint `/users/{user_id}/following`.
8. Dapatkan postingan pengguna dengan endpoint `/users/{user_id}/posts`.

### Postingan (Posts)

1. Buat postingan baru dengan endpoint `/posts`.
2. Lihat semua postingan dengan endpoint `/posts`.
3. Lihat postingan berdasarkan ID dengan endpoint `/posts/{post_id}`.
4. Edit postingan dengan endpoint `/posts/{post_id}`.
5. Hapus postingan dengan endpoint `/posts/{post_id}`.
6. Suka atau tidak suka postingan menggunakan endpoint `/posts/{post_id}/like`.
7. Tambahkan komentar ke postingan menggunakan endpoint `/posts/{post_id}/comment`.
8. Hapus komentar dengan endpoint `/posts/comment/{comment_id}`.

## Kontribusi

Kami mengundang kontribusi dari komunitas! Silakan laporkan bug, ajukan fitur baru, atau kirimkan pull request. Lihat [CONTRIBUTING.md](CONTRIBUTING.md) untuk panduan kontribusi.

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
