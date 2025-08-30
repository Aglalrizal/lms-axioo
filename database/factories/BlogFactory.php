<?php

namespace Database\Factories;

use App\Enums\BlogStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blog;
use App\Models\BlogCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $blogCategoryId = BlogCategory::inRandomOrder()->first()->id;

        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'content' => $this->generateJoditContent(),
            'excerpt' => $this->generateExcerpt(),
            'status' => fake()->randomElement(BlogStatus::values()),
            'user_id' => rand(1, 2),
            'blog_category_id' => $blogCategoryId,
            'photo_path' => $this->getRequiredSampleThumbnail(),

            'created_at' => now(),
            'updated_at' => now(),
            'published_at' => now(),
        ];
    }


    /**
     * Generate realistic Jodit editor content
     */
    private function generateJoditContent(): string
    {
        $paragraphs = [
            "<p>Selamat datang di kursus yang akan mengubah karir Anda! Kursus ini dirancang khusus untuk memberikan pemahaman mendalam tentang teknologi terkini dengan pendekatan praktis dan mudah dipahami.</p>",

            "<p><strong>Apa yang akan Anda pelajari:</strong></p>
            <ul>
                <li>Konsep fundamental dan teori dasar</li>
                <li>Implementasi praktis dengan studi kasus nyata</li>
                <li>Best practices dan industry standards</li>
                <li>Tips dan trik dari para ahli</li>
            </ul>",

            "<p><em>Kursus ini cocok untuk:</em></p>
            <ol>
                <li>Pemula yang ingin memulai karir di bidang teknologi</li>
                <li>Profesional yang ingin meningkatkan skill</li>
                <li>Mahasiswa yang mencari pengetahuan praktis</li>
                <li>Entrepreneur yang ingin memahami teknologi</li>
            </ol>",

            "<blockquote>
                <p>\"Investasi terbaik adalah investasi pada pengetahuan dan keterampilan diri sendiri. Kursus ini akan memberikan Anda foundation yang kuat untuk berkembang di era digital.\"</p>
            </blockquote>",

            "<p>Dengan materi yang <strong>terstruktur</strong> dan <em>up-to-date</em>, Anda akan mendapatkan pembelajaran yang komprehensif. Setiap modul dilengkapi dengan:</p>
            <ul>
                <li>Video pembelajaran berkualitas tinggi</li>
                <li>Materi bacaan lengkap</li>
                <li>Quiz interaktif</li>
                <li>Assignment praktis</li>
                <li>Forum diskusi dengan instruktur dan peserta lain</li>
            </ul>",

            "<p>Jangan lewatkan kesempatan untuk meningkatkan kemampuan Anda. Daftar sekarang dan mulai perjalanan pembelajaran yang mengubah hidup!</p>"
        ];

        // Pilih 3-5 paragraf secara acak
        $selectedParagraphs = fake()->randomElements($paragraphs, fake()->numberBetween(5, 6));

        return implode("\n\n", $selectedParagraphs);
    }

    /**
     * Generate short description for course preview
     */
    private function generateExcerpt(): string
    {
        $shortDescriptions = [
            'Pelajari skill teknologi terkini dengan metode pembelajaran praktis dan mudah dipahami. Cocok untuk pemula hingga level menengah. Kursus komprehensif yang memadukan teori dan praktik untuk membangun kemampuan profesional di bidang teknologi modern. Dapatkan pengetahuan mendalam melalui video pembelajaran, studi kasus nyata, dan project-based learning yang aplikatif. Program pelatihan intensif dengan materi terkini dan mentor berpengalaman. Tingkatkan karir Anda dengan skill yang dibutuhkan industri. Pembelajaran fleksibel dengan kurikulum yang dirancang khusus untuk mengembangkan kemampuan praktis dan theoretical knowledge. Kursus interaktif dengan pendekatan hands-on learning. Dapatkan sertifikat dan portfolio yang dapat meningkatkan nilai profesional Anda. Materi pembelajaran terstruktur dan up-to-date dengan industry best practices. Dilengkapi quiz, assignment, dan forum diskusi.Program pelatihan yang menggabungkan fundamental theory dengan real-world application. Cocok untuk career development.',
            'Pelajari skill teknologi terkini dengan metode pembelajaran praktis dan mudah dipahami. Cocok untuk pemula hingga level menengah. Kursus komprehensif yang memadukan teori dan praktik untuk membangun kemampuan profesional di bidang teknologi modern. Dapatkan pengetahuan mendalam melalui video pembelajaran, studi kasus nyata, dan project-based learning yang aplikatif. Program pelatihan intensif dengan materi terkini dan mentor berpengalaman. Tingkatkan karir Anda dengan skill yang dibutuhkan industri. Pembelajaran fleksibel dengan kurikulum yang dirancang khusus untuk mengembangkan kemampuan praktis dan theoretical knowledge. Kursus interaktif dengan pendekatan hands-on learning. Dapatkan sertifikat dan portfolio yang dapat meningkatkan nilai profesional Anda. Materi pembelajaran terstruktur dan up-to-date dengan industry best practices. Dilengkapi quiz, assignment, dan forum diskusi.Program pelatihan yang menggabungkan fundamental theory dengan real-world application. Cocok untuk career development.',
        ];

        return fake()->randomElement($shortDescriptions);
    }

    /**
     * State: Course with base64 images for testing image processing
     */
    public function withBase64Images(): static
    {
        return $this->state(function (array $attributes) {
            // Simplified: langsung ambil single base64 image
            $base64Image = $this->loadSingleBase64Image();

            $contentWithImages = $attributes['content'] .
                "\n\n<p>Contoh gambar dalam konten:</p>" .
                "\n<p><img src=\"{$base64Image}\" alt=\"Course Sample Image\" width=\"400\" height=\"300\" style=\"border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);\" /></p>" .
                "\n\n<p>Gambar ini adalah placeholder yang menyerupai thumbnail course professional seperti yang biasa ditemukan di platform pembelajaran online.</p>";

            return [
                'content' => $contentWithImages,
            ];
        });
    }

    /**
     * Load single base64 image
     */
    private function loadSingleBase64Image(): string
    {
        $filePath = public_path('assets/images/base64sample.txt');

        if (!file_exists($filePath)) {
            // Fallback jika file tidak ada
            return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==';
        }

        $content = trim(file_get_contents($filePath));

        return !empty($content) ?
            $content :
            'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==';
    }

    /**
     * Get required sample thumbnail - WAJIB ada image
     */
    private function getRequiredSampleThumbnail(): string
    {
        $samplesPath = public_path('assets/images/samples');

        // Check if samples directory exists
        if (!is_dir($samplesPath)) {
            throw new \Exception("Directory sample images tidak ditemukan: {$samplesPath}. Silakan buat folder dan upload sample images terlebih dahulu.");
        }

        $imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $sampleImages = [];

        // Get all image files from samples directory
        foreach (scandir($samplesPath) as $file) {
            if ($file === '.' || $file === '..') continue;

            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($extension, $imageExtensions)) {
                $sampleImages[] = $file;
            }
        }

        // Throw error if no sample images found
        if (empty($sampleImages)) {
            throw new \Exception("Tidak ada sample images ditemukan di: {$samplesPath}. Silakan upload file gambar (.jpg, .jpeg, .png, .gif, .webp) ke folder tersebut terlebih dahulu.");
        }

        // Return random sample image path
        $randomImage = fake()->randomElement($sampleImages);
        return 'assets/images/samples/' . $randomImage;
    }
}
