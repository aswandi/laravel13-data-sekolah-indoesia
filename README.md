# 🏫 Data Sekolah Indonesia

Website database sekolah seluruh Indonesia yang menampilkan **204.535+ sekolah** dari **38 provinsi** dengan navigasi hierarkis wilayah, peta interaktif, dan statistik lengkap.

Dibangun menggunakan **Laravel 13** dengan desain modern, responsif, dan SEO-friendly.

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Leaflet](https://img.shields.io/badge/Leaflet.js-Maps-199900?style=for-the-badge&logo=leaflet&logoColor=white)

---

## ✨ Fitur Utama

### 🗺️ Navigasi Hierarkis Wilayah
- **Provinsi** → **Kabupaten/Kota** → **Kecamatan** → **Detail Sekolah**
- Tabel data dengan statistik di setiap level wilayah
- Breadcrumb navigation untuk kemudahan navigasi

### 📊 Statistik Wilayah
- Total sekolah, negeri, swasta di setiap wilayah
- Breakdown per jenjang pendidikan (SD/MI, SMP, SMA/SMK)
- Counter animation pada kartu statistik
- Animated stat bars pada detail sekolah

### 📍 Peta Interaktif (Leaflet.js)
- Marker warna-warni berdasarkan jenjang pendidikan
- Popup info sekolah dengan link detail
- Auto-fit bounds untuk menampilkan semua sekolah dalam wilayah
- Link langsung ke Google Maps

### 🔍 Pencarian Cepat
- Real-time search di navbar
- Cari berdasarkan nama sekolah atau NPSN
- Autocomplete dengan info wilayah lengkap

### 🔎 SEO Friendly
- Meta tags dinamis (title, description, keywords) per halaman
- JSON-LD Structured Data (Schema.org `School`)
- Sitemap XML (`/sitemap.xml`)
- URL yang deskriptif dan readable
- Open Graph meta tags

### 🎨 Desain Modern
- Latar belakang terang dengan animasi gradient orb
- Glassmorphism navbar
- Animate On Scroll (AOS) effects
- Responsif untuk mobile dan desktop
- Badge warna-warni untuk status dan jenjang

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel 13 (PHP 8.3) |
| Database | MySQL 8.0 |
| Maps | Leaflet.js + OpenStreetMap |
| Animasi | AOS (Animate On Scroll) |
| Icons | Font Awesome 6 |
| Font | Plus Jakarta Sans (Google Fonts) |
| CSS | Vanilla CSS (custom design system) |

---

## 📦 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL 8.0+
- Database `033_scrap_data_sekolah` dengan tabel `sekolah_detail`, `sekolah_statistik`, dan `kepala_sekolah`

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/aswandi/laravel13-data-sekolah-indoesia.git
   cd laravel13-data-sekolah-indoesia
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Konfigurasi environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Edit file `.env`** — sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=033_scrap_data_sekolah
   DB_USERNAME=root
   DB_PASSWORD=your_password

   SESSION_DRIVER=file
   CACHE_STORE=array
   QUEUE_CONNECTION=sync
   ```

   > ⚠️ **Penting:** Gunakan `SESSION_DRIVER=file`, `CACHE_STORE=array` atau `file`, dan `QUEUE_CONNECTION=sync` agar tidak memerlukan tabel migrasi tambahan di database.

5. **Jalankan server**
   ```bash
   php artisan serve
   ```

6. **Akses website** di `http://127.0.0.1:8000`

---

## 📁 Struktur Database

Website ini membaca data dari database yang sudah ada tanpa melakukan modifikasi apapun.

### Tabel `sekolah_detail`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| npsn | varchar | Primary key, Nomor Pokok Sekolah Nasional |
| nama | varchar | Nama sekolah |
| bentuk_pendidikan | varchar | SD, SMP, SMA, SMK, dll |
| status_sekolah | varchar | NEGERI / SWASTA |
| provinsi | varchar | Nama provinsi |
| kabupaten | varchar | Nama kabupaten/kota |
| kecamatan | varchar | Nama kecamatan |
| alamat_jalan | varchar | Alamat lengkap |
| lintang | double | Koordinat latitude |
| bujur | double | Koordinat longitude |
| akreditasi | varchar | Nilai akreditasi |
| ... | ... | dan kolom lainnya |

### Tabel `sekolah_statistik`
Berisi data statistik per sekolah (rasio guru-siswa, persentase guru sertifikasi, dll).

### Tabel `kepala_sekolah`
Berisi data kepala sekolah dan PTK terkait.

---

## 🗂️ Struktur Proyek

```
app/
├── Http/Controllers/
│   └── WilayahController.php    # Controller utama
├── Models/
│   ├── SekolahDetail.php        # Model sekolah
│   ├── SekolahStatistik.php     # Model statistik
│   └── KepalaSekolah.php        # Model kepala sekolah
resources/views/
├── layouts/
│   └── app.blade.php            # Layout utama + CSS + JS
├── wilayah/
│   ├── index.blade.php          # Homepage (daftar provinsi)
│   ├── provinsi.blade.php       # Daftar kabupaten/kota
│   ├── kabupaten.blade.php      # Daftar kecamatan
│   ├── kecamatan.blade.php      # Daftar sekolah + peta
│   └── sekolah.blade.php        # Detail sekolah
└── sitemap.blade.php            # Sitemap XML
routes/
└── web.php                      # Route definitions
```

---

## 🌐 Routes

| Method | URI | Keterangan |
|--------|-----|------------|
| GET | `/` | Homepage - daftar provinsi |
| GET | `/provinsi/{provinsi}` | Daftar kabupaten/kota |
| GET | `/provinsi/{provinsi}/{kabupaten}` | Daftar kecamatan |
| GET | `/provinsi/{provinsi}/{kabupaten}/{kecamatan}` | Daftar sekolah + peta |
| GET | `/sekolah/{npsn}` | Detail sekolah |
| GET | `/cari` | API pencarian |
| GET | `/sitemap.xml` | Sitemap XML |

---

## 📝 Catatan Penting

- **Database tidak dimodifikasi** — website hanya membaca (READ-ONLY) dari database yang sudah ada
- **Tidak perlu menjalankan migration** — semua tabel sudah tersedia di database
- Gunakan driver `file` untuk session dan `array`/`file` untuk cache agar tidak memerlukan tabel tambahan
- Untuk performa optimal di production, pertimbangkan menambahkan index pada kolom `provinsi`, `kabupaten`, `kecamatan`, dan `npsn`

---

## 📄 Lisensi

Project ini dibuat untuk keperluan edukasi dan informasi publik tentang data sekolah di Indonesia.

---

## 🙏 Credits

- Data sekolah bersumber dari [Kemendikdasmen](https://sekolah.data.kemendikdasmen.go.id/)
- Peta menggunakan [OpenStreetMap](https://www.openstreetmap.org/) via [Leaflet.js](https://leafletjs.com/)
- Icons oleh [Font Awesome](https://fontawesome.com/)
- Font [Plus Jakarta Sans](https://fonts.google.com/specimen/Plus+Jakarta+Sans) dari Google Fonts
