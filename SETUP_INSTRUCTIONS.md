# Instruksi Setup Fitur Komentar

## 1. Update Database Schema

Jalankan script SQL berikut di database MySQL Anda:

```sql
-- Tambahkan kolom untuk fitur soft delete dan edit tracking
ALTER TABLE bug_comments 
ADD COLUMN is_deleted TINYINT(1) DEFAULT 0,
ADD COLUMN deleted_at TIMESTAMP NULL,
ADD COLUMN is_edited TINYINT(1) DEFAULT 0,
ADD COLUMN edited_at TIMESTAMP NULL;
```

### Cara Menjalankan Script:

1. **Via phpMyAdmin:**
   - Buka phpMyAdmin
   - Pilih database `flowtask`
   - Klik tab "SQL"
   - Copy-paste script di atas
   - Klik "Go"

2. **Via Command Line:**
   ```bash
   mysql -u root -p flowtask < database/update_comments_schema.sql
   ```

3. **Via MySQL Workbench:**
   - Buka MySQL Workbench
   - Connect ke database
   - Jalankan script SQL

## 2. File yang Telah Ditambahkan/Dimodifikasi

### File yang Dimodifikasi:
- `app/controllers/ApiController.php` - Ditambahkan endpoint `deleteComment()` dan `editComment()`
- `app/views/bugs/view.php` - Ditambahkan tombol edit/delete dan JavaScript
- `app/views/tasks/view.php` - Ditambahkan tombol edit/delete dan JavaScript

### File yang Dibuat:
- `database/update_comments_schema.sql` - Script untuk update database
- `app/views/layouts/comment_actions.js` - JavaScript untuk aksi komentar
- `app/views/layouts/comment_styles.css` - CSS untuk styling komentar
- `app/views/bugs/comment.php` - Helper functions untuk komentar
- `app/views/bugs/comments_example.php` - Contoh penggunaan
- `COMMENT_FEATURES.md` - Dokumentasi fitur

## 3. Fitur yang Tersedia

### Hapus Komentar:
- Komentar tidak benar-benar dihapus (soft delete)
- Menampilkan pesan "Komentar ini telah dihapus"
- Hanya penulis atau admin yang bisa menghapus

### Edit Komentar:
- Menampilkan indikator "(diedit)" untuk komentar yang diedit
- Hanya penulis atau admin yang bisa mengedit
- Menyimpan waktu edit untuk tracking

## 4. Testing

Setelah menjalankan script SQL, fitur edit dan delete komentar akan tersedia di:
- `http://localhost/flowtask/index.php?url=bugs/view/11`
- `http://localhost/flowtask/index.php?url=tasks/view/60`

## 5. Troubleshooting

Jika ada masalah:
1. Pastikan script SQL berhasil dijalankan
2. Cek console browser untuk error JavaScript
3. Pastikan file CSS dan JS ter-load dengan benar
4. Cek permission user untuk edit/delete komentar
