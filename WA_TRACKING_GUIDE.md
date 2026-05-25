# 📊 Fitur WhatsApp Click Tracking

## 🎯 Deskripsi Fitur

Sistem tracking otomatis untuk mencatat setiap klik tombol WhatsApp di website. Fitur ini akan:
- ✅ Mencatat setiap klik tombol WhatsApp dari pengunjung
- ✅ Menampilkan statistik real-time di dashboard admin
- ✅ Menyimpan history lengkap dengan detail IP, waktu, dan halaman
- ✅ Menampilkan grafik trend per jam dan per hari
- ✅ Export data ke CSV untuk analisis lebih lanjut
- ✅ Auto-reset data harian (tapi history tetap tersimpan)

---

## 🚀 Instalasi & Setup

### 1. Import Database Schema

Jalankan file SQL migration untuk membuat tabel dan view yang diperlukan:

```bash
# Via phpMyAdmin
- Import file: migrations/create_wa_clicks_tracking.sql

# Via MySQL Command Line
mysql -u root -p db_sikubah < migrations/create_wa_clicks_tracking.sql
```

**Yang akan dibuat:**
- Tabel `wa_clicks` - Menyimpan setiap klik
- Tabel `wa_daily_stats` - Ringkasan per hari
- Tabel `wa_page_stats` - Statistik per halaman
- View untuk query yang lebih mudah
- Trigger otomatis untuk update statistik
- Event scheduler untuk cleanup data lama

### 2. Verifikasi Tabel Sudah Dibuat

```sql
SHOW TABLES LIKE 'wa_%';
-- Harus menampilkan:
-- wa_clicks
-- wa_daily_stats
-- wa_page_stats
```

### 3. Test Query

```sql
-- Test view statistik hari ini
SELECT * FROM v_today_wa_stats;

-- Test stored procedure
CALL sp_get_wa_dashboard_stats();
```

---

## 📁 File-File yang Ditambahkan

### 1. **Migration SQL**
- `migrations/create_wa_clicks_tracking.sql`
  - Schema database lengkap
  - Views, triggers, dan stored procedures

### 2. **Controller**
- `application/controllers/WaTracking.php`
  - API endpoint untuk tracking: `/watracking/track`
  - Halaman statistik: `/watracking/stats`
  - History klik: `/watracking/history`
  - Export CSV: `/watracking/export`

### 3. **View**
- `application/views/admin/wa_stats.php`
  - Dashboard statistik dengan grafik
  - Menampilkan data real-time
  - Auto-refresh setiap 5 menit

### 4. **JavaScript**
- `assets/js/wa-tracker.js`
  - Otomatis mendeteksi semua tombol WhatsApp
  - Mengirim tracking data ke server
  - Support untuk dynamic content
  - Menggunakan `navigator.sendBeacon()` untuk reliability

### 5. **Update File Existing**
- `index.php` - Tambah route `watracking` & script tracker
- `pages/menu/*.php` - Semua halaman menu + script tracker
- `pages/menu/assesoris/*.php` - Semua halaman assesoris + script tracker
- `application/controllers/Dashboard.php` - Tampilkan widget WA stats
- `application/views/admin/dashboard.php` - Card statistik WA
- `application/views/admin/components/sidebar.php` - Menu WhatsApp Stats

---

## 🎨 Cara Kerja Sistem

### Flow Tracking:

1. **Pengunjung mengklik tombol WhatsApp**
   ```
   User Click → JavaScript Intercept → Send to API → Save to DB → Redirect to WA
   ```

2. **Data yang dicatat:**
   - Nama halaman (index, produk, harga, dll)
   - URL lengkap halaman
   - Tipe tombol (sticky, inline, footer)
   - IP address pengunjung
   - User agent (browser & device info)
   - Referer (halaman sebelumnya)
   - Tanggal dan waktu klik

3. **Proses penyimpanan:**
   - Data disimpan ke tabel `wa_clicks`
   - Trigger otomatis update `wa_daily_stats`
   - Trigger otomatis update `wa_page_stats`

### Auto-Reset Harian:

Sistem akan:
- ✅ **Reset counter harian** setiap pukul 00:00
- ✅ **Simpan history** ke tabel `wa_daily_stats` (permanent)
- ✅ **Cleanup data raw** setelah 90 hari (opsional)
- ✅ **Tetap tampilkan trend** 7 hari terakhir

---

## 📊 Statistik yang Ditampilkan

### Dashboard Admin (Halaman Utama)
- 📱 Klik WA Hari Ini
- 👥 Pengunjung Unik WA (IP berbeda)

### Halaman WhatsApp Stats (`/watracking/stats`)

**1. Ringkasan Hari Ini:**
- Total klik hari ini
- Pengunjung unik (IP berbeda)
- Halaman terpopuler
- Total semua klik (all time)

**2. Grafik:**
- 📊 Bar Chart: Klik per jam (hari ini)
- 📈 Line Chart: Trend 7 hari terakhir

**3. Tabel:**
- 📋 Statistik per halaman (hari ini)
  - Nama halaman
  - Total klik
  - Pengunjung unik
  - Waktu klik pertama & terakhir
- 📅 Ringkasan 7 hari terakhir
  - Tanggal
  - Total klik
  - Pengunjung unik
  - Jumlah halaman yang diklik

**4. Fitur Tambahan:**
- 🔄 Auto-refresh setiap 5 menit
- 💾 Export ke CSV
- 📜 View history lengkap

---

## 🔗 URL & Routing

### Frontend (Tracking):
- Semua halaman otomatis ter-track jika ada tombol WA
- Script `wa-tracker.js` bekerja otomatis

### Backend (Admin):
- **Login Admin**: `/auth/login`
- **Dashboard**: `/dashboard` (tampilkan widget WA stats)
- **WhatsApp Stats**: `/watracking/stats`
- **History**: `/watracking/history`
- **Export CSV**: `/watracking/export?start_date=2026-01-01&end_date=2026-01-31`

### API Endpoint:
- **Track Click**: `/watracking/track` (POST)
  - Parameters: `page_name`, `page_url`, `button_type`
  - Response: JSON success/error

---

## 🧪 Testing Fitur

### Test 1: Verifikasi Script Loaded
1. Buka halaman website (index, produk, dll)
2. Buka Browser Console (F12)
3. Cari di Network tab → File `wa-tracker.js` harus loaded
4. Di Console, tidak boleh ada error

### Test 2: Test Tracking
1. Klik tombol WhatsApp di halaman manapun
2. Buka phpMyAdmin → Tabel `wa_clicks`
3. Harus ada record baru dengan data klik

### Test 3: Verifikasi Dashboard
1. Login ke admin: `/auth/login`
2. Buka Dashboard → Lihat widget "Klik WA Hari Ini"
3. Angka harus sesuai dengan jumlah klik
4. Klik "Lihat Detail →" untuk halaman statistik lengkap

### Test 4: Verifikasi Grafik
1. Buka `/watracking/stats`
2. Grafik per jam harus muncul
3. Grafik 7 hari harus muncul
4. Tabel statistik harus ada data

### Test 5: Export CSV
1. Buka `/watracking/export`
2. File CSV harus terdownload
3. Buka dengan Excel/LibreOffice
4. Data harus lengkap dan terformat baik

---

## 📱 Halaman yang Sudah Ter-track

Tombol WhatsApp di halaman berikut sudah otomatis ter-track:

1. ✅ **index.php** (Homepage)
2. ✅ **pages/menu/produk.php**
3. ✅ **pages/menu/harga.php**
4. ✅ **pages/menu/blog.php**
5. ✅ **pages/menu/article_detail.php**
6. ✅ **pages/menu/assesoris/lampu-gantung-masjid.php**
7. ✅ **pages/menu/assesoris/menara-masjid.php**
8. ✅ **pages/menu/assesoris/mihrab-masjid-grc.php**
9. ✅ **pages/menu/assesoris/replika-pintu-nabawi.php**

**Semua tombol WhatsApp di halaman ini akan otomatis tercatat!**

---

## 🛠️ Maintenance & Monitoring

### Query Manual untuk Monitoring

```sql
-- Statistik hari ini
SELECT * FROM v_today_wa_stats;

-- Per halaman hari ini
SELECT * FROM v_today_page_stats;

-- Trend 7 hari
SELECT * FROM v_wa_weekly_stats;

-- Total keseluruhan
SELECT * FROM v_wa_total_stats;

-- 10 klik terakhir
SELECT * FROM wa_clicks ORDER BY created_at DESC LIMIT 10;

-- Halaman terpopuler sepanjang masa
SELECT page_name, COUNT(*) as total 
FROM wa_clicks 
GROUP BY page_name 
ORDER BY total DESC;
```

### Cleanup Manual (jika diperlukan)

```sql
-- Hapus data raw lebih dari 90 hari (history tetap ada di daily_stats)
DELETE FROM wa_clicks WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);

-- Reset data hari ini (hati-hati!)
DELETE FROM wa_clicks WHERE click_date = CURDATE();
UPDATE wa_daily_stats SET total_clicks = 0 WHERE stat_date = CURDATE();
```

---

## 🎨 Customization

### Mengubah Interval Auto-Refresh
Edit file `application/views/admin/wa_stats.php`:
```javascript
// Auto refresh setiap 5 menit (300000 ms)
setTimeout(() => {
    location.reload();
}, 300000); // Ubah nilai ini
```

### Mengubah Retention Period
Edit file `migrations/create_wa_clicks_tracking.sql`:
```sql
-- Cleanup data raw setiap 90 hari
DELETE FROM wa_clicks 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
-- Ubah "90 DAY" sesuai kebutuhan
```

### Menambah Halaman Tracking
Jika ada halaman baru dengan tombol WA:
1. Tambahkan script sebelum `</body>`:
```html
<script src="https://produsenkubahmasjid.id/assets/js/wa-tracker.js"></script>
```
2. Tombol WA akan otomatis ter-track!

---

## 🐛 Troubleshooting

### Masalah: Klik tidak tercatat

**Solusi:**
1. Cek Browser Console untuk error
2. Pastikan script `wa-tracker.js` loaded
3. Cek Network tab → Request ke `/watracking/track` harus ada
4. Verifikasi tabel `wa_clicks` ada di database

### Masalah: Dashboard tidak tampil data

**Solusi:**
1. Pastikan ada data di tabel `wa_clicks`
2. Cek query error di PHP error log
3. Test query manual di phpMyAdmin
4. Pastikan user login sebagai admin

### Masalah: Grafik tidak muncul

**Solusi:**
1. Cek Browser Console untuk Chart.js error
2. Pastikan CDN Chart.js loaded
3. Verifikasi data JSON dari controller valid

### Masalah: Export CSV kosong

**Solusi:**
1. Cek parameter `start_date` dan `end_date`
2. Pastikan ada data di range tanggal tersebut
3. Cek permissions folder untuk write

---

## 📈 Analisis Data

### Insight yang Bisa Didapat:

1. **Peak Hours**: Jam berapa pengunjung paling banyak klik WA?
2. **Popular Pages**: Halaman mana yang paling banyak menghasilkan lead?
3. **Conversion Rate**: Berapa % pengunjung yang klik WA?
4. **Daily Trend**: Hari apa traffic WA paling tinggi?
5. **Unique vs Total**: Berapa banyak repeat clicks vs new visitors?

### Tips Optimasi:

- 📍 Fokuskan konten di halaman dengan klik WA tertinggi
- 🕐 Pastikan tim sales siap di jam peak hours
- 📱 Optimalkan tombol WA di halaman populer
- 📊 Monitor trend weekly untuk strategi marketing

---

## ✅ Checklist Deploy ke Production

- [ ] Import SQL migration ke database production
- [ ] Verifikasi semua tabel dibuat
- [ ] Test tracking di production
- [ ] Verifikasi dashboard admin accessible
- [ ] Test export CSV
- [ ] Enable event scheduler di production MySQL
- [ ] Setup backup untuk tabel `wa_daily_stats`
- [ ] Dokumentasikan untuk tim

---

## 📞 Support & Kontak

Jika ada pertanyaan atau masalah:
- Cek documentation ini terlebih dahulu
- Review code di file-file yang disebutkan
- Test dengan data dummy dulu
- Backup database sebelum modify

---

**Status: ✅ READY FOR PRODUCTION**

Fitur sudah lengkap dan siap digunakan di production server!
