# 📚 Aplikasi Manajemen Siswa
**PHP OOP + MySQL | Praktikum Pemrograman Web**

---

## 🗂️ Struktur Folder

```
siswa-app/
├── config/
│   └── Database.php       ← Class koneksi database (OOP)
├── classes/
│   └── Siswa.php          ← Class model Siswa (CRUD)
├── pages/
│   ├── tambah.php         ← Halaman tambah siswa
│   └── edit.php           ← Halaman edit siswa
├── index.php              ← Halaman utama (daftar siswa)
├── database.sql           ← Script buat tabel + data dummy
└── README.md
```

---

## ⚙️ Cara Menjalankan

### 1. Persiapan
- Pastikan **XAMPP / Laragon** sudah terinstal
- Aktifkan **Apache** dan **MySQL**

### 2. Letakkan Project
Salin folder `siswa-app` ke:
```
C:/xampp/htdocs/siswa-app        (XAMPP Windows)
/opt/lampp/htdocs/siswa-app      (XAMPP Linux)
```

### 3. Import Database
1. Buka **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Klik **Import** → pilih file `database.sql`
3. Klik **Go**

### 4. Buka di Browser
```
http://localhost/siswa-app/
```

---

## 🔑 Konfigurasi Database
Edit file `config/Database.php` sesuai kebutuhan:
```php
private $host     = 'localhost';
private $db_name  = 'db_siswa';
private $username = 'root';
private $password = '';          // isi jika ada password
```

---

## ✅ Fitur Aplikasi
| Fitur | Keterangan |
|-------|-----------|
| 📋 Lihat Data | Menampilkan semua data siswa |
| 🔍 Pencarian | Cari berdasarkan nama, NIS, atau kelas |
| ➕ Tambah | Form tambah siswa baru dengan validasi |
| ✏️ Edit | Ubah data siswa yang sudah ada |
| 🗑️ Hapus | Hapus data siswa dengan konfirmasi |

---

## 🧱 Konsep OOP yang Digunakan
- **Class & Object** → `Database`, `Siswa`
- **Encapsulation** → properti private, method public
- **Constructor** → inisialisasi koneksi otomatis
- **Abstraction** → logika query tersembunyi di dalam class

---

## 🛠️ Teknologi
- PHP 7.4+ (OOP)
- MySQL / MariaDB
- Koneksi: `php-mysqli` (bukan PDO)
- UI: HTML + CSS murni (tanpa framework)
