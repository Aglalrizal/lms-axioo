# Base64 Images Handler Trait - DRY Solution

Trait `HandlesBase64Images` menyediakan solusi DRY (Don't Repeat Yourself) untuk menangani processing base64 images dan cleanup gambar yang tidak terpakai di berbagai komponen Livewire.

## Features

✅ **Process Base64 Images** - Konversi base64 images ke file storage  
✅ **Remove Unused Images** - Hapus gambar yang tidak lagi digunakan  
✅ **Extract Image URLs** - Ekstrak URL gambar dari konten  
✅ **Cleanup Orphan Images** - Bersihkan gambar yatim piatu  
✅ **Flexible Folder Structure** - Mendukung berbagai folder storage

## Usage

### 1. Import Trait di Livewire Component

```php
<?php

namespace App\Livewire\Forms;

use App\Traits\HandlesBase64Images;
use Livewire\Form;

class YourForm extends Form
{
    use HandlesBase64Images;

    // Your code here...
}
```

### 2. Process Base64 Images

```php
public function store()
{
    // Process base64 images sebelum save
    $this->content = $this->processBase64Images($this->content, 'your_folder');

    // Validate and save...
    $validated = $this->validate();
    YourModel::create($validated);
}
```

### 3. Remove Unused Images saat Update

```php
public function update()
{
    $oldContent = $this->model->content;

    // Process base64 images
    $this->content = $this->processBase64Images($this->content, 'your_folder');

    $this->validate();

    // Remove unused images
    $this->removeUnusedImages($oldContent, $this->content, 'your_folder');

    $this->model->update($this->all());
}
```

### 4. Cleanup Orphan Images (Manual Command)

```bash
# Preview gambar yang akan dihapus
php artisan content:cleanup-images --folder=blog_images --dry-run

# Hapus gambar yang tidak terpakai dari blog content
php artisan content:cleanup-images --folder=blog_images

# Hapus thumbnail blog yang tidak terpakai
php artisan content:cleanup-images --folder=blog_thumbnails

# Cleanup course content images
php artisan content:cleanup-images --folder=course_images

# Cleanup semua folder
php artisan content:cleanup-images
```

## Available Methods

### processBase64Images(string $content, string $folder = 'content_images'): string

Konversi base64 images dalam konten menjadi file yang tersimpan.

**Parameters:**

-   `$content` - Konten HTML yang mengandung base64 images
-   `$folder` - Folder storage untuk menyimpan gambar (default: 'content_images')

**Returns:** Konten dengan base64 images diganti URL file

### removeUnusedImages(string $oldContent, string $newContent, string $folder = 'content_images'): void

Hapus gambar yang tidak lagi digunakan setelah update konten.

**Parameters:**

-   `$oldContent` - Konten lama
-   `$newContent` - Konten baru
-   `$folder` - Folder storage untuk dicek

### getContentImages(string $content, string $folder = 'content_images'): array

Dapatkan semua path gambar dari konten untuk folder tertentu.

**Parameters:**

-   `$content` - Konten untuk diekstrak
-   `$folder` - Folder storage untuk difilter

**Returns:** Array path file relatif

### cleanupOrphanImages(array $allContentWithImages, string $folder = 'content_images'): array

Bersihkan gambar yatim piatu yang tidak digunakan dalam konten manapun.

**Parameters:**

-   `$allContentWithImages` - Array berisi semua konten yang perlu dicek
-   `$folder` - Folder storage untuk dibersihkan

**Returns:** Array file yang dihapus

## Folder Structure

Trait ini mendukung struktur folder yang fleksibel:

```
storage/app/public/
├── blog_images/          # Gambar blog content (dari rich text editor)
├── blog_thumbnails/      # Thumbnail blog (dari upload file)
├── course_images/        # Gambar course content (dari rich text editor)
└── content_images/      # Gambar konten umum (default)
```

## Example Implementation

### BlogForm.php

```php
class BlogForm extends Form
{
    use HandlesBase64Images;

    public function store()
    {
        $this->content = $this->processBase64Images($this->content, 'blog_images');
        // ... rest of store logic
    }

    public function update()
    {
        $oldContent = $this->blog->content;
        $this->content = $this->processBase64Images($this->content, 'blog_images');
        // ... validation
        $this->removeUnusedImages($oldContent, $this->content, 'blog_images');
        // ... rest of update logic
    }
}
```

### CourseContent.php

```php
class CourseContent extends Component
{
    use HandlesBase64Images;

    public function save()
    {
        $this->content = $this->processBase64Images($this->content, 'course_images');

        if ($this->isUpdating) {
            $oldContent = $this->courseContent->content;
            // ... update logic
            $this->removeUnusedImages($oldContent, $this->content, 'course_images');
        }
        // ... save logic
    }
}
```

## Benefits

1. **DRY Principle** - Satu trait untuk semua komponen
2. **Consistent Behavior** - Perilaku yang sama di semua tempat
3. **Easy Maintenance** - Update di satu tempat, berlaku di semua tempat
4. **Flexible Configuration** - Dapat disesuaikan per use case
5. **Automatic Cleanup** - Tidak ada file orphan yang menumpuk
6. **Error Handling** - Handle error dengan graceful

## Command Usage Examples

```bash
# Preview blog content images cleanup
php artisan content:cleanup-images --folder=blog_images --dry-run

# Preview blog thumbnails cleanup
php artisan content:cleanup-images --folder=blog_thumbnails --dry-run

# Cleanup course images
php artisan content:cleanup-images --folder=course_images

# Cleanup semua folder yang didukung
php artisan content:cleanup-images

# Preview semua folder
php artisan content:cleanup-images --dry-run
```

## Adding New Content Types

Untuk menambah tipe konten baru yang menggunakan rich text editor, update method `getAllContentForFolder` di command:

```php
case 'new_content_images':
    $newContents = NewContentModel::select('content')->get();
    foreach ($newContents as $content) {
        if ($content->content) {
            $allContent[] = $content->content;
        }
    }
    break;
```

Lalu gunakan trait di komponen yang sesuai:

```php
class NewContentForm extends Form
{
    use HandlesBase64Images;

    public function store()
    {
        $this->content = $this->processBase64Images($this->content, 'new_content_images');
        // ...
    }
}
```
