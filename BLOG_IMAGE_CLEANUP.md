# Blog Image Management System

Sistem untuk mengelola gambar blog dengan penyimpanan yang efisien dan cleanup otomatis.

## Cara Kerja

### 1. Gambar di Editor

-   Gambar yang dimasukkan ke editor disimpan sebagai **base64** sementara
-   Tidak ada upload langsung ke server saat menambah gambar di editor
-   Gambar baru diproses dan disimpan ke file saat blog di-create/update

### 2. Saat Create/Update Blog

-   Base64 images di konten dikonversi dan disimpan ke folder `blog_images`
-   Gambar lama yang tidak lagi digunakan dihapus dari storage
-   URL base64 diganti dengan URL file yang sebenarnya

### 3. Saat Delete Blog

-   Semua gambar terkait (thumbnail + konten) dihapus dari storage

### 4. Command Manual Cleanup

-   `php artisan blog:cleanup-images --dry-run` untuk preview
-   `php artisan blog:cleanup-images` untuk cleanup aktual

## File yang Dimodifikasi

-   `app/Livewire/Forms/BlogForm.php` - Logic processing base64 dan cleanup
-   `app/Models/Blog.php` - Event listener saat delete
-   `app/Console/Commands/CleanupBlogImages.php` - Command manual
-   `public/assets/js/vendors/editor.js` - Editor dengan base64 image handler

## Benefit

✅ **Tidak ada upload berlebihan** - Gambar hanya disimpan saat benar-benar diperlukan  
✅ **Storage efisien** - Gambar yang tidak terpakai otomatis dihapus  
✅ **User experience baik** - Editor responsive tanpa upload delay  
✅ **Cleanup otomatis** - Tidak ada file orphan yang menumpuk

## Testing

```bash
# Preview gambar yang akan dihapus
php artisan blog:cleanup-images --dry-run

# Hapus gambar yang tidak terpakai
php artisan blog:cleanup-images
```
