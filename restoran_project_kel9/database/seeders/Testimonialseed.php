<?php


namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class Testimonialseed extends Seeder
{
    public function run(): void
    {
        // Masukkan data testimonial tanpa gambar
        $testimonialData = [
            [
                'id' => 1,
                'nama' => 'Anya Geraldine',
                'email' => 'anya@gmail.com',
                'nomor_telfon' => '081234567890',
                'pesan' => 'Saya sangat terkesan dengan pengalaman makan saya di Han`s Resto. Dari suasana yang hangat hingga hidangan yang lezat, semuanya luar biasa. Pelayanan yang ramah dan profesional membuat saya merasa benar-benar istimewa.',
                // 'image' => '6671f19f54bc1_anya.png',
            ],
            [
                'id' => 2,
                'nama' => 'Rigen',
                'email' => 'rigen@gmail.com',
                'nomor_telfon' => '1234123434',
                'pesan' => 'Han`s restaurant adalah tempat yang sempurna untuk makan malam romantis. Makanan yang lezat dan presentasi yang menakjubkan membuat kami terpesona. Kami pasti akan kembali lagi.',
                // 'image' => '6671f2ca7d145_rigen.png',
            ],
            [
                'id' => 3,
                'nama' => 'Anastasya Kosasih',
                'email' => 'anastasyakosasih@gmail.com',
                'nomor_telfon' => '081234567890',
                'pesan' => 'Han`s restaurant telah menjadi tempat favorit saya untuk bersantap. Hidangan mereka selalu segar dan penuh rasa, dan suasana restoran sangat mengundang. Ini adalah tempat yang sempurna untuk menikmati waktu bersama keluarga dan teman-teman.',
                // 'image' => '6671f352daedb_anastasya.png',
            ]
        ];
        Testimonial::insert($testimonialData);

        // foreach ($testimonialData as $data) {
        //     $testimonial = Testimonial::create([
        //         'id' => $data['id'],
        //         'nama' => $data['nama'],
        //         'email' => $data['email'],
        //         'nomor_telfon' => $data['nomor_telfon'],
        //         'pesan' => $data['pesan'],
        //     ]);

        //     // Tambahkan gambar ke testimonial menggunakan Spatie Media Library
        //     $testimonial->addMedia(storage_path("app/public/1/{$data['image']}"))
        //                 ->preservingOriginal()
        //                 ->toMediaCollection('image');
        // }
    }
}




