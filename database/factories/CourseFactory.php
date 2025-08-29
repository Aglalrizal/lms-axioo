<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Program;
use App\Models\User;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    // // Usage
    // // Basic course dengan konten WYSIWYG
    // $course = Course::factory()->create();

    // // Course dengan base64 images (untuk testing image processing)
    // $courseWithImages = Course::factory()->withBase64Images()->create();

    // // Course dengan konten minimal
    // $minimalCourse = Course::factory()->minimal()->create();

    // // Course dengan konten kompleks
    // $complexCourse = Course::factory()->complex()->create();

    // // Course dengan program spesifik
    // $courseWithProgram = Course::factory()->withProgram(3)->create();

    // // Course tanpa program
    // $courseWithoutProgram = Course::factory()->withoutProgram()->create();

    // // Kombinasi states
    // $course = Course::factory()
    //     ->advanced()
    //     ->paid()
    //     ->published()
    //     ->withProgram()
    //     ->create();

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->generateCourseTitle(),
            'duration' => fake()->numberBetween(1, 120), // 1-120 jam
            'course_category_id' => CourseCategory::inRandomOrder()->first()?->id ?? CourseCategory::factory()->create()->id,
            'teacher_id' => User::role('instructor')->inRandomOrder()->first()?->id ?? User::factory()->create()->assignRole('instructor')->id,
            'program_id' => fake()->boolean(50) ? Program::inRandomOrder()->first()?->id  : null, // 50% chance memiliki program
            'level' => fake()->randomElement(["beginner", "intermediate", "advanced"]),
            'access_type' => fake()->randomElement(["free_trial", "free", "paid"]),
            'description' => $this->generateJoditContent(),
            'short_desc' => $this->generateShortDescription(),

            'thumbnail' => $this->getRequiredSampleThumbnail(),

            'extra_description' => null, // Akan diset di step 4
            'is_published' => false, // Default draft

            'price' => function (array $attributes) {
                return $attributes['access_type'] === 'paid'
                    ? fake()->numberBetween(50000, 2000000)
                    : 0;
            },

            'created_by' => function () {
                return Auth::user()?->username ?? 'system';
            },
            'modified_by' => function () {
                return Auth::user()?->username ?? 'system';
            },
        ];
    }

    /**
     * Generate realistic course title
     */
    private function generateCourseTitle(): string
    {
        $topics = [
            'Web Development',
            'Mobile Development',
            'Data Science',
            'Machine Learning',
            'Digital Marketing',
            'UI/UX Design',
            'Database Management',
            'Cloud Computing',
            'Cybersecurity',
            'DevOps',
            'Artificial Intelligence',
            'Blockchain',
            'Python Programming',
            'JavaScript Fundamentals',
            'React Development'
        ];

        $levels = ['Dasar', 'Lanjutan', 'Mahir', 'Profesional', 'Komprehensif'];
        $formats = ['Praktis', 'Lengkap', 'Intensif', 'Mudah Dipahami'];

        $topic = fake()->randomElement($topics);
        $modifier = fake()->randomElement(array_merge($levels, $formats));

        return "{$topic} {$modifier}";
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
        $selectedParagraphs = fake()->randomElements($paragraphs, fake()->numberBetween(3, 5));

        return implode("\n\n", $selectedParagraphs);
    }

    /**
     * Generate short description for course preview
     */
    private function generateShortDescription(): string
    {
        $shortDescriptions = [
            'Pelajari skill teknologi terkini dengan metode pembelajaran praktis dan mudah dipahami. Cocok untuk pemula hingga level menengah.',
            'Kursus komprehensif yang memadukan teori dan praktik untuk membangun kemampuan profesional di bidang teknologi modern.',
            'Dapatkan pengetahuan mendalam melalui video pembelajaran, studi kasus nyata, dan project-based learning yang aplikatif.',
            'Program pelatihan intensif dengan materi terkini dan mentor berpengalaman. Tingkatkan karir Anda dengan skill yang dibutuhkan industri.',
            'Pembelajaran fleksibel dengan kurikulum yang dirancang khusus untuk mengembangkan kemampuan praktis dan theoretical knowledge.',
            'Kursus interaktif dengan pendekatan hands-on learning. Dapatkan sertifikat dan portfolio yang dapat meningkatkan nilai profesional Anda.',
            'Materi pembelajaran terstruktur dan up-to-date dengan industry best practices. Dilengkapi quiz, assignment, dan forum diskusi.',
            'Program pelatihan yang menggabungkan fundamental theory dengan real-world application. Cocok untuk career development.',
        ];

        return fake()->randomElement($shortDescriptions);
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
     * State: Course without thumbnail (untuk testing khusus - bypass required image)
     */
    public function withoutThumbnail(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'thumbnail' => null,
            ];
        });
    }

    /**
     * State: Course with base64 images for testing image processing
     */
    public function withBase64Images(): static
    {
        return $this->state(function (array $attributes) {
            // Simplified: langsung ambil single base64 image
            $base64Image = $this->loadSingleBase64Image();

            $contentWithImages = $attributes['description'] .
                "\n\n<p>Contoh gambar dalam konten:</p>" .
                "\n<p><img src=\"{$base64Image}\" alt=\"Course Sample Image\" width=\"400\" height=\"300\" style=\"border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);\" /></p>" .
                "\n\n<p>Gambar ini adalah placeholder yang menyerupai thumbnail course professional seperti yang biasa ditemukan di platform pembelajaran online.</p>";

            return [
                'description' => $contentWithImages,
            ];
        });
    }

    /**
     * State: Published course
     */
    public function published(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_published' => true,
            ];
        });
    }

    /**
     * State: Free trial course
     */
    public function freeTrial(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'access_type' => 'free_trial',
                'price' => 0,
                'duration' => fake()->numberBetween(1, 10), // Course trial biasanya singkat
            ];
        });
    }

    /**
     * State: Free course
     */
    public function free(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'access_type' => 'free',
                'price' => 0,
            ];
        });
    }

    /**
     * State: Paid course
     */
    public function paid(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'access_type' => 'paid',
                'price' => fake()->numberBetween(100000, 2000000),
            ];
        });
    }

    /**
     * State: Beginner level course
     */
    public function beginner(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'level' => 'beginner',
                'duration' => fake()->numberBetween(10, 40),
            ];
        });
    }

    /**
     * State: Intermediate level course
     */
    public function intermediate(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'level' => 'intermediate',
                'duration' => fake()->numberBetween(30, 80),
            ];
        });
    }

    /**
     * State: Advanced level course
     */
    public function advanced(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'level' => 'advanced',
                'duration' => fake()->numberBetween(60, 120),
            ];
        });
    }

    /**
     * State: Course without program
     */
    public function withoutProgram(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'program_id' => null,
            ];
        });
    }

    /**
     * State: Course with specific program
     */
    public function withProgram($programId = null): static
    {
        return $this->state(function (array $attributes) use ($programId) {
            return [
                'program_id' => $programId ?? Program::inRandomOrder()->first()?->id,
            ];
        });
    }
}
