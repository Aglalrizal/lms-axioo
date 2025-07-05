<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::insert([
            // Most Asked (id = 1)
            [
                'faq_category_id' => 1,
                'question' => 'Bagaimana cara mendaftar akun?',
                'answer' => 'Klik tombol "Daftar", isi formulir, lalu verifikasi email kamu.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 1,
                'question' => 'Apakah kursus ini gratis?',
                'answer' => 'Beberapa kursus gratis, tapi sebagian berbayar. Cek detail kursusnya.',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 1,
                'question' => 'Bagaimana cara mendapatkan sertifikat?',
                'answer' => 'Kamu harus menyelesaikan semua modul dan lulus evaluasi akhir.',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // General Inquiries (id = 2)
            [
                'faq_category_id' => 2,
                'question' => 'Apakah saya bisa mengakses kursus setelah selesai?',
                'answer' => 'Ya, akses kursus tetap tersedia setelah selesai selama akun aktif.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 2,
                'question' => 'Bisakah saya belajar lewat HP?',
                'answer' => 'Tentu saja! Platform kami mendukung mobile-friendly interface.',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 2,
                'question' => 'Berapa lama durasi kursus?',
                'answer' => 'Tergantung kursusnya. Rata-rata antara 4 hingga 12 minggu.',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Support (id = 3)
            [
                'faq_category_id' => 3,
                'question' => 'Saya tidak bisa login, harus bagaimana?',
                'answer' => 'Gunakan fitur "Lupa Password" atau hubungi tim support.',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 3,
                'question' => 'Bagaimana cara menghubungi tim support?',
                'answer' => 'Kamu bisa kirim email ke support@domainmu.com atau isi form bantuan.',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 3,
                'question' => 'Saya tidak menemukan kursus yang saya beli.',
                'answer' => 'Coba periksa tab "Kursus Saya" di dashboard. Jika masih hilang, hubungi support.',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
