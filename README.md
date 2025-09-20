# 🍳 Dapur Aunty Fahira

**Dapur Aunty Fahira** adalah aplikasi web berbasis **Laravel (PHP)** yang dirancang untuk kebutuhan manajemen dapur, seperti pengelolaan resep, stok bahan, pesanan, dan laporan.  
Aplikasi ini menggunakan **AdminLTE** sebagai template dashboard admin yang responsif, serta didukung oleh **JavaScript, CSS, HTML, dan SCSS** di sisi frontend.

---

## 📑 Daftar Isi
- [Tentang Proyek](#-tentang-proyek)
- [Fitur](#-fitur)
- [Struktur Direktori](#-struktur-direktori)
- [Instalasi](#-instalasi)
- [Cara Penggunaan](#-cara-penggunaan)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## 📖 Tentang Proyek
**Dapur Aunty Fahira** membantu dalam mengelola dapur secara digital, mulai dari pencatatan resep hingga laporan penjualan.  
Dengan integrasi **AdminLTE**, admin dapat dengan mudah memantau aktivitas dan data melalui dashboard interaktif.

---

## ✨ Fitur
- 📘 **Manajemen resep masakan**
- 🥦 **Pengelolaan stok bahan dapur**
- 🛒 **Sistem pemesanan menu**
- 📊 **Laporan penjualan dan stok**
- 🖥 **Dashboard admin responsif (AdminLTE)**
- 🔑 **Otentikasi & otorisasi pengguna**
- 🗄 **Migrasi database & ORM dengan Eloquent Laravel**

---

## 📂 Struktur Direktori
```bash
.
├── app/                # Kode backend Laravel (controller, model, dll)
├── public/
│   ├── assets/         # Asset frontend, termasuk AdminLTE
│   └── index.php
├── resources/
│   ├── views/          # Template Blade (HTML)
├── routes/
│   └── web.php         # Routing aplikasi
├── database/           # Migrasi & seeder database
├── package.json        # Konfigurasi npm (JavaScript dependencies)
├── composer.json       # Konfigurasi composer (PHP dependencies)
└── README.md
```

---

## ⚙️ Instalasi

### 🔧 Prasyarat
- PHP >= 7.4
- Composer
- Node.js & npm
- MySQL/MariaDB

### 🚀 Langkah Instalasi
1. **Clone repository**
   ```bash
   git clone https://github.com/Dapur-Aunty-Fahira/dapur-aunty-fahira.git
   cd dapur-aunty-fahira
   ```

2. **Install dependency PHP**
   ```bash
   composer install
   ```

3. **Install dependency JavaScript**
   ```bash
   npm install
   ```

4. **Copy file environment**
   ```bash
   cp .env.example .env
   ```

5. **Generate key aplikasi**
   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi database**  
   Edit file `.env` dan sesuaikan dengan pengaturan database Anda:
   ```
   DB_DATABASE=nama_database
   DB_USERNAME=user
   DB_PASSWORD=pass
   ```

7. **Migrasi database**
   ```bash
   php artisan migrate
   ```

8. **Jalankan server lokal**
   ```bash
   php artisan serve
   ```

9. **Build asset frontend**
   - Untuk development:
     ```bash
     npm run dev
     ```
   - Untuk production:
     ```bash
     npm run production
     ```

---

## 🖥 Cara Penggunaan
1. Akses aplikasi melalui browser di [http://localhost:8000](http://localhost:8000).  
2. Login sebagai admin untuk masuk ke dashboard.  
3. Kelola resep, stok, dan pesanan melalui menu yang tersedia.  
4. Pantau laporan penjualan & stok di dashboard.  

---

## 📄 Lisensi
Proyek ini menggunakan lisensi **MIT**.  
Lihat file [LICENSE](LICENSE) untuk informasi lebih lanjut.
