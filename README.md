# SIKUBAH - Admin Dashboard System

> **Jasa Kubah Masjid Management System** dengan CodeIgniter 3 Mini Framework

## 🎯 Overview

SIKUBAH adalah sistem manajemen website untuk bisnis jasa kubah masjid yang dibangun dengan PHP dan CodeIgniter 3. Sistem ini menyediakan:

- ✅ Admin authentication (login/logout)
- ✅ Admin dashboard dengan navigation
- ✅ Responsive design dengan Bootstrap 5
- ✅ Database management (MySQL)
- ✅ Session handling
- ✅ Dynamic URL routing

## 📦 Tech Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Framework**: CodeIgniter 3 (Mini Version)
- **Frontend**: Bootstrap 5, HTML5, CSS3
- **Server**: Apache (dengan mod_rewrite)

## 🚀 Quick Start

### Prerequisites
- Laragon atau local PHP development environment
- MySQL Server
- Apache with mod_rewrite enabled

### Installation

1. **Pastikan sudah di folder proyek**
```bash
cd d:\laragon\www\SIKUBAH
```

2. **Jalankan setup database**
```bash
php setup.php
```

Database otomatis akan membuat:
- Database: `sikubah`
- 3 Tabel: `admins`, `pages`, `content`
- Admin default: `admin` / `admin123`

3. **Akses aplikasi**
- Home: http://localhost/SIKUBAH/
- Admin: http://localhost/SIKUBAH/admin/auth/login

## 📁 Project Structure

```
SIKUBAH/
├── application/                  # Aplikasi utama
│   ├── config/                  # Konfigurasi
│   │   ├── config.php           # Config aplikasi
│   │   └── database.php         # Config database
│   ├── controllers/             # Business logic
│   │   ├── Auth.php             # Login/logout
│   │   ├── Admin.php            # Admin dashboard
│   │   └── Home.php             # Homepage
│   ├── models/                  # Database models
│   ├── views/                   # View templates
│   │   ├── admin/
│   │   │   └── dashboard.php    # Admin dashboard
│   │   ├── auth/
│   │   │   └── login.php        # Login page
│   │   └── home/
│   │       └── index.php        # Home page
│   └── drivers/
├── system/                       # Core framework
├── assets/                       # Static files
│   ├── css/
│   └── js/
├── index.php                    # Entry point
├── .htaccess                    # URL rewriting
├── setup.php                    # Database setup
├── test.php                     # Setup checker
├── SETUP_GUIDE.md              # Installation guide
└── README.md                    # This file
```

## 🔐 Authentication

### Default Admin Account
```
Username: admin
Password: admin123
```

⚠️ **SECURITY WARNING**: Ubah password ini setelah login pertama!

### Login Flow
1. User ke `/SIKUBAH/auth/login`
2. Masukkan username & password
3. Sistem validasi ke database `admins` table
4. Jika valid, set session `admin_logged_in = true`
5. Redirect ke `/SIKUBAH/admin`

### Logout
```
/SIKUBAH/auth/logout
```
Menghapus session dan redirect ke login page.

## 🔗 URL Routing

Sistem menggunakan dynamic routing. Format: `/controller/method/param1/param2/...`

```
GET  /SIKUBAH/                      → Landing page (Homepage)
GET  /SIKUBAH/admin/                → Admin dashboard (jika login)
GET  /SIKUBAH/admin/auth/login      → Admin login page
POST /SIKUBAH/admin/auth/login      → Process login
GET  /SIKUBAH/admin/auth/logout     → Admin logout
GET  /SIKUBAH/admin/pages           → Manage pages [future]
```

## 💾 Database Schema

### Table: admins
```sql
CREATE TABLE admins (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Table: pages
```sql
CREATE TABLE pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT,
    published TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Table: content
```sql
CREATE TABLE content (
    id INT PRIMARY KEY AUTO_INCREMENT,
    page_id INT NOT NULL,
    section VARCHAR(100),
    title VARCHAR(255),
    description LONGTEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
);
```

## 🔧 Configuration

### application/config/config.php
```php
$config['base_url'] = 'http://localhost/SIKUBAH/';
$config['index_page'] = '';  // Remove untuk clean URL
$config['encryption_key'] = 'sikubah_secret_key_2026';  // Change ini!
$config['sess_expiration'] = 7200;  // Session timeout
```

### application/config/database.php
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'sikubah',
    'dbdriver' => 'mysqli',
    ...
);
```

## 🛡️ Security Best Practices

### Before Going to Production

1. **Delete setup.php**
   ```bash
   rm setup.php
   ```

2. **Change default admin password**
   - Login dengan admin/admin123
   - Ganti password ke yang strong

3. **Update encryption key**
   Edit `application/config/config.php`:
   ```php
   $config['encryption_key'] = 'generate-random-string-here';
   ```

4. **Disable error display**
   Edit `index.php`:
   ```php
   define('ENVIRONMENT', 'production');
   ```

5. **Enable HTTPS**
   - Get SSL certificate
   - Configure server untuk HTTPS
   - Update base_url ke https://

6. **Database backup**
   - Setup regular backups
   - Test restore procedure

## 📊 Admin Dashboard

Dashboard admin menampilkan:
- ✓ Greeting pesan
- ✓ Quick stats (total pages, images, messages)
- ✓ Feature overview
- ✓ Navigation menu

Menu yang tersedia:
1. **Dashboard** - Overview statistik
2. **Kelola Pages** - Tambah/edit/hapus halaman (coming soon)
3. **Kelola Konten** - Update konten halaman (coming soon)
4. **Pengaturan** - Konfigurasi website (coming soon)

## 🚧 Upcoming Features

Fitur yang akan ditambahkan:

- [ ] Page management (create, edit, delete)
- [ ] Content management interface
- [ ] Image upload functionality
- [ ] Contact form submissions
- [ ] Multi-user admin system
- [ ] Role-based access control
- [ ] Activity logging
- [ ] Backup functionality

## 🐛 Troubleshooting

### 404 Error - Controller not found
**Solusi:**
- Pastikan file controller ada di `application/controllers/`
- Nama file harus match dengan class name
- Huruf pertama harus capital (e.g., `Auth.php` untuk class `Auth`)

### Database Connection Error
**Solusi:**
1. Pastikan MySQL running
2. Verifikasi credentials di `application/config/database.php`
3. Jalankan `php setup.php` lagi
4. Check file `test.php` untuk diagnose

### URLs masih punya index.php
**Solusi:**
1. Pastikan `.htaccess` ada di root
2. Enable Apache `mod_rewrite`:
   ```bash
   a2enmod rewrite
   ```
3. Edit `application/config/config.php`:
   ```php
   $config['index_page'] = '';
   ```
4. Restart Apache

### Session tidak bekerja
**Solusi:**
1. Pastikan PHP session handler benar
2. Check `session.save_path` di php.ini
3. Pastikan folder tmp accessible

## 📖 File Reference

| File | Purpose |
|------|---------|
| `index.php` | Main entry point & router |
| `.htaccess` | URL rewriting rules |
| `setup.php` | Database setup script (delete after setup) |
| `test.php` | Setup verification |
| `SETUP_GUIDE.md` | Detailed installation guide |
| `INFO.txt` | Quick reference info |

## 🆘 Support & Help

### Check These First
1. Baca `SETUP_GUIDE.md` untuk detailed instructions
2. Jalankan `test.php` untuk diagnose issues
3. Check error log di browser console
4. Verify database connection dengan `test.php`

### Common Issues
- Pastikan **MySQL running**
- Pastikan **Apache mod_rewrite enabled**
- Pastikan **PHP version ≥ 7.4**
- Delete **setup.php** setelah first setup

## 📝 License

Project SIKUBAH - Copyrights reserved

## 🎓 Credits

Developed for SIKUBAH - Jasa Kubah Masjid  
Framework: CodeIgniter 3 Mini  
UI Framework: Bootstrap 5

---

**Version**: 1.0.0  
**Last Updated**: May 19, 2026  
**Status**: ✅ Ready for Development
