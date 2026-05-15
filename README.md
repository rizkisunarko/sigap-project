# Sistem Informasi ICU

Sistem informasi berbasis web untuk pengelolaan data pasien ICU, pencatatan kondisi pasien oleh perawat, serta pemantauan kondisi pasien oleh keluarga secara daring.

---

## Tech Stack

| Teknologi | Kegunaan |
|---|---|
| PHP Native | Backend & logika aplikasi |
| Bootstrap 5 | UI Framework (frontend) |
| MySQL | Database |
| XAMPP | Local development server |

---

## Fitur Utama

- Login & autentikasi berbasis role (Perawat / Keluarga Pasien)
- Pencatatan data kondisi pasien ICU secara digital
- Notifikasi otomatis jika kondisi pasien memburuk
- Riwayat dan visualisasi grafik perkembangan kondisi pasien
- Sinkronisasi data rekam medis pasien lama
- Manajemen keterlambatan input data
- Akses informasi kondisi pasien oleh keluarga secara daring
- Pendaftaran pasien (jalur Umum, BPJS, dan IGD)
- Unggah dokumen rujukan untuk pasien BPJS
- Verifikasi nomor rekam medis pasien lama

---

## Struktur Direktori

```
D:.
│   .gitignore
│   README.md
│
├───app
│   ├───controllers
│   │       AuthController.php
│   │       DashboardController.php
│   │       KeluargaController.php
│   │       NotifikasiController.php
│   │       PasienController.php
│   │       PemeriksaanController.php
│   │       PendaftaranController.php
│   │       PerawatController.php
│   │       RekamMedisController.php
│   │
│   ├───models
│   │       DokumenRujukan.php
│   │       KeluargaPasien.php
│   │       Notifikasi.php
│   │       Pasien.php
│   │       Pemeriksaan.php
│   │       Pendaftaran.php
│   │       Perawat.php
│   │       RekamMedis.php
│   │       User.php
│   │
│   └───views
│       ├───auth
│       │       login.php
│       │       reset_password.php
│       │
│       ├───errors
│       │       403.php
│       │       404.php
│       │
│       ├───keluarga
│       │       dashboard.php
│       │       kondisi_pasien.php
│       │       notifikasi.php
│       │       riwayat_tindakan.php
│       │
│       ├───layouts
│       │       footer.php
│       │       header.php
│       │       sidebar_keluarga.php
│       │       sidebar_perawat.php
│       │
│       ├───pendaftaran
│       │       form_bpjs.php
│       │       form_umum.php
│       │       jalur_igd.php
│       │       pilih_jalur.php
│       │       unggah_rujukan.php
│       │       verifikasi_rekam_medis.php
│       │
│       └───perawat
│               dashboard.php
│               input_data_pasien.php
│               manajemen_input.php
│               riwayat_pasien.php
│               sinkronisasi_rekam_medis.php
│               visualisasi_data.php
│
├───config
│       app.php
│       database.php
│
├───core
│       Controller.php
│       Database.php
│       Model.php
│       Router.php
│
├───database
│       sistem_icu.sql
│
├───public
│   │   index.php
│   │
│   ├───assets
│   │   ├───img
│   │   └───uploads
│   │       └───dokumen_rujukan
│   ├───css
│   │       bootstrap.min.css
│   │       custom.css
│   │
│   └───js
│           bootstrap.bundle.min.js
│           custom.js
│           jquery.min.js
│
└───routes
        web.php
```

---

## Penjelasan Direktori

### `app/`
Direktori utama aplikasi yang berisi seluruh logika MVC.

#### `app/controllers/`
Berisi file controller yang bertugas menerima request dari user, memproses data melalui model, lalu meneruskan hasilnya ke view. Setiap file controller bertanggung jawab atas satu modul fitur.

| File | Kegunaan |
|---|---|
| `AuthController.php` | Menangani login, logout, dan reset password |
| `DashboardController.php` | Menampilkan halaman dashboard sesuai role |
| `PasienController.php` | Manajemen data pasien (tambah, edit, lihat) |
| `PerawatController.php` | Fitur khusus perawat (input data, riwayat, visualisasi) |
| `KeluargaController.php` | Fitur khusus keluarga pasien (lihat kondisi, riwayat) |
| `NotifikasiController.php` | Mengelola pengiriman dan pembacaan notifikasi |
| `RekamMedisController.php` | Sinkronisasi dan pengelolaan rekam medis pasien |
| `PemeriksaanController.php` | Input dan manajemen data hasil pemeriksaan pasien |
| `PendaftaranController.php` | Proses pendaftaran pasien (umum, BPJS, IGD) |

#### `app/models/`
Berisi file model yang bertugas berkomunikasi langsung dengan database MySQL. Setiap model merepresentasikan satu tabel di database.

| File | Tabel / Kegunaan |
|---|---|
| `User.php` | Tabel users — data akun login semua pengguna |
| `Pasien.php` | Tabel pasien — data identitas pasien |
| `Perawat.php` | Tabel perawat — data identitas perawat |
| `KeluargaPasien.php` | Tabel keluarga_pasien — relasi keluarga dengan pasien |
| `RekamMedis.php` | Tabel rekam_medis — riwayat kunjungan pasien |
| `Pemeriksaan.php` | Tabel pemeriksaan — hasil observasi kondisi pasien |
| `Notifikasi.php` | Tabel notifikasi — data notifikasi kondisi pasien |
| `Pendaftaran.php` | Tabel pendaftaran — data pendaftaran layanan pasien |
| `DokumenRujukan.php` | Tabel dokumen_rujukan — file surat rujukan pasien BPJS |

#### `app/views/`
Berisi file tampilan HTML yang dirender ke browser. Dikelompokkan berdasarkan modul dan role pengguna.

| Subfolder | Kegunaan |
|---|---|
| `auth/` | Halaman login dan reset password |
| `errors/` | Halaman error 403 (akses ditolak) dan 404 (halaman tidak ditemukan) |
| `layouts/` | Komponen tampilan yang dipakai ulang (header, footer, sidebar) |
| `perawat/` | Halaman khusus untuk role perawat |
| `keluarga/` | Halaman khusus untuk role keluarga pasien |
| `pendaftaran/` | Halaman alur pendaftaran pasien |

---

### `config/`
Berisi file konfigurasi global aplikasi.

| File | Kegunaan |
|---|---|
| `database.php` | Konfigurasi koneksi database (host, user, password, nama DB) |
| `app.php` | Konfigurasi umum aplikasi (base URL, nama aplikasi, timezone) |

---

### `core/`
Berisi class inti yang menjadi fondasi arsitektur MVC. File-file ini tidak perlu diubah kecuali ada kebutuhan pengembangan framework.

| File | Kegunaan |
|---|---|
| `Router.php` | Membaca URL dan meneruskan ke controller yang sesuai |
| `Controller.php` | Base class yang diextend oleh semua controller |
| `Model.php` | Base class yang diextend oleh semua model |
| `Database.php` | Mengelola koneksi ke MySQL menggunakan Singleton pattern |

---

### `database/`
Berisi file SQL untuk keperluan setup database.

| File | Kegunaan |
|---|---|
| `sistem_icu.sql` | File dump database lengkap — import ke phpMyAdmin untuk setup awal |

---

### `public/`
Satu-satunya folder yang dapat diakses langsung oleh browser. Semua request masuk melalui `index.php` sebagai entry point.

| Subfolder / File | Kegunaan |
|---|---|
| `index.php` | Entry point utama — semua URL diarahkan ke sini |
| `css/` | File stylesheet (Bootstrap dan custom CSS) |
| `js/` | File JavaScript (Bootstrap bundle, jQuery, custom JS) |
| `assets/img/` | Gambar statis seperti logo dan ikon |
| `assets/uploads/dokumen_rujukan/` | Penyimpanan file surat rujukan yang diunggah pasien BPJS |

---

### `routes/`
| File | Kegunaan |
|---|---|
| `web.php` | Mendefinisikan seluruh URL routing aplikasi — menghubungkan URL dengan controller dan method yang menanganinya |

---

## Cara Setup (XAMPP)

### 1. Clone Repository
```bash
git clone https://github.com/username/sistem-icu.git
cd sistem-icu
```

### 2. Pindahkan ke Folder XAMPP
Salin folder project ke:
```
C:/xampp/htdocs/sistem-icu
```

### 3. Import Database
- Buka **phpMyAdmin** di `http://localhost/phpmyadmin`
- Buat database baru dengan nama `sistem_icu`
- Pilih database tersebut, klik tab **Import**
- Upload file `database/sistem_icu.sql`

### 4. Konfigurasi Database
Edit file `config/database.php` sesuaikan dengan pengaturan XAMPP kamu:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');         // isi jika ada password
define('DB_NAME', 'sistem_icu');
```

### 5. Jalankan Aplikasi
Buka browser dan akses:
```
http://localhost/sistem-icu/public
```

---

## Alur Kolaborasi Git

```
main
 └── dev
      ├── feature/auth-login
      ├── feature/input-data-pasien
      ├── feature/notifikasi
      ├── feature/pendaftaran
      └── feature/keluarga-dashboard
```

- Jangan push langsung ke `main`
- Buat branch baru dari `dev` untuk setiap fitur
- Setelah selesai, buat **Pull Request** ke `dev`
- `dev` di-merge ke `main` setelah semua fitur selesai dan diuji

### Konvensi Penamaan Branch
```
feature/nama-fitur       → fitur baru
fix/nama-bug             → perbaikan bug
hotfix/nama-perbaikan    → perbaikan mendesak di main
```

