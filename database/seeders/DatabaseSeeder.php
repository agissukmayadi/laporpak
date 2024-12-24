<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
   public function run(): void
    {
        DB::table('abouts')->insert([
            [
                'id' => 1,
                'description' => 'LaporPak.com adalah platform digital inovatif yang memungkinkan masyarakat Indonesia berperan aktif dalam menjaga dan memperbaiki kualitas lingkungan dengan melaporkan masalah yang ada di sekitar'
            ]
        ]);

        DB::table('contacts')->insert([
            [
                'id' => 1,
                'address' => 'Jl. Pagelaran, Kec.Ciomas, Kab.Bogor (16610)',
                'phone' => '08515625611',
                'email' => 'laporpak@gmail.com',
            ]
        ]);

        // Seeder untuk tabel faqs
        DB::table('faqs')->insert([
            [
                'id' => 1,
                'question' => "Apa itu LaporPak.com?",
                'answer' => "LaporPak.com adalah platform online yang memungkinkan masyarakat untuk melaporkan berbagai masalah umum yang mereka temui, seperti masalah infrastruktur, kebersihan, keamanan, pelayanan publik, dan kesehatan. Melalui LaporPak.com, masyarakat dapat menyampaikan keluhan atau laporan secara langsung dan memastikan bahwa permasalahan tersebut mendapat perhatian yang sesuai.",
            ],
            [
                'id' => 2,
                'question' => "Bagaimana cara membuat laporan?",
                'answer' => "Pengguna dapat membuat laporan dengan mengakses LaporPak.com, mendaftar atau login ke akun mereka, kemudian mengisi formulir laporan dengan rincian masalah yang ingin mereka laporkan. Setelah itu, laporan akan dikirimkan dan diproses oleh pihak terkait.",
            ],
            [
                'id' => 3,
                'question' => "Apa yang terjadi setelah laporan dibuat?",
                'answer' => "Setelah laporan dibuat, laporan tersebut akan ditinjau oleh tim kami atau pihak berwenang terkait. Pengguna akan diberi notifikasi mengenai status laporan mereka hingga laporan tersebut ditangani atau ditutup.",
            ],
            [
                'id' => 4,
                'question' => "Apakah ada biaya untuk membuat laporan?",
                'answer' => "Tidak, pembuatan laporan melalui LaporPak.com sepenuhnya gratis dan dapat diakses oleh siapa saja yang membutuhkan.",
            ],
            [
                'id' => 5,
                'question' => "Bagaimana jika laporan saya tidak ditanggapi?",
                'answer' => "Jika laporan tidak mendapat tanggapan dalam waktu yang wajar, pengguna dapat menghubungi layanan pelanggan kami untuk tindak lanjut atau menggunakan fitur yang disediakan untuk mengajukan keluhan lebih lanjut.",
            ],
        ]);

        DB::table('categories')->insert([
            [
                'id' => 9,
                'name' => 'Infrastruktur',
                'created_at' => '2024-11-05 14:11:47',
                'updated_at' => '2024-11-05 14:11:47',
                'deleted_at' => null,
            ],
            [
                'id' => 10,
                'name' => 'Kesehatan',
                'created_at' => '2024-11-05 14:11:55',
                'updated_at' => '2024-11-05 14:11:55',
                'deleted_at' => null,
            ],
            [
                'id' => 11,
                'name' => 'Lingkungan',
                'created_at' => '2024-11-05 14:12:03',
                'updated_at' => '2024-11-05 14:12:03',
                'deleted_at' => null,
            ],
            [
                'id' => 12,
                'name' => 'Keamanan',
                'created_at' => '2024-11-05 14:12:07',
                'updated_at' => '2024-11-05 14:12:07',
                'deleted_at' => null,
            ],
            [
                'id' => 13,
                'name' => 'Pelayanan Publik',
                'created_at' => '2024-11-05 14:12:17',
                'updated_at' => '2024-11-05 14:12:17',
                'deleted_at' => null,
            ],
            [
                'id' => 14,
                'name' => 'Pendidikan',
                'created_at' => '2024-11-05 14:12:28',
                'updated_at' => '2024-11-05 14:12:28',
                'deleted_at' => null,
            ],
            [
                'id' => 15,
                'name' => 'Transportasi',
                'created_at' => '2024-11-05 14:12:36',
                'updated_at' => '2024-11-05 14:12:36',
                'deleted_at' => null,
            ],
            [
                'id' => 16,
                'name' => 'Sosial',
                'created_at' => '2024-11-05 14:12:46',
                'updated_at' => '2024-11-05 14:12:46',
                'deleted_at' => null,
            ],
            [
                'id' => 17,
                'name' => 'Layanan Air Bersih',
                'created_at' => '2024-11-05 14:13:00',
                'updated_at' => '2024-11-05 14:13:00',
                'deleted_at' => null,
            ],
            [
                'id' => 18,
                'name' => 'Listrik dan Energi',
                'created_at' => '2024-11-05 14:13:08',
                'updated_at' => '2024-11-05 14:13:08',
                'deleted_at' => null,
            ],
        ]);

        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone' => '085156134923',
                'email_verified_at' => null,
                'password' => '$2y$12$fvUMdiq4wWMxruj/F7Ac6uoxEgbUUxfgVKRmTVniKHjl83F9VsRPa',
                'role' => 'Admin',
                'region' => null,
                'is_verified' => 1,
                'remember_token' => null,
                'created_at' => '2024-11-04 03:50:28',
                'updated_at' => '2024-11-04 03:50:28',
                'deleted_at' => null
            ],
            [
                'id' => 5,
                'name' => 'Agis Sukmayadi',
                'email' => 'agissukmayadi@gmail.com',
                'phone' => '085156134923',
                'email_verified_at' => null,
                'password' => '$2y$12$T0nVTaGDEq6uTSvbGwslUucA6o.NtyOqXaLn9B6kfgbZ.5TCSevqG',
                'role' => 'Citizen',
                'region' => null,
                'is_verified' => 1,
                'remember_token' => null,
                'created_at' => '2024-11-04 03:57:39',
                'updated_at' => '2024-11-04 03:57:39',
                'deleted_at' => null
            ],
            [
                'id' => 6,
                'name' => 'Pemerintah Daerah Kota Bogor',
                'email' => 'kotabogor@gmail.com',
                'phone' => '02565165',
                'email_verified_at' => null,
                'password' => '$2y$12$Q4ECGdq1zlwHDO8Auk5/eedrOJr2rrvpchbrXoUTN0PTKStJzulgG',
                'role' => 'Goverment',
                'region' => 'KOTA BOGOR',
                'is_verified' => 1,
                'remember_token' => null,
                'created_at' => '2024-11-04 08:18:43',
                'updated_at' => '2024-11-04 08:18:43',
                'deleted_at' => null
            ],
            [
                'id' => 7,
                'name' => 'Pemerintah Daerah Kabupaten Kerinci',
                'email' => 'kabkerinci@gmail.com',
                'phone' => '17864862',
                'email_verified_at' => null,
                'password' => '$2y$12$h0z6Kl1/WwkB6/0N8gtb7e58q4kPCThhrLes0m9NbXBrumuWK3m4q',
                'role' => 'Goverment',
                'region' => 'KAB. KERINCI',
                'is_verified' => 1,
                'remember_token' => null,
                'created_at' => '2024-11-04 17:41:29',
                'updated_at' => '2024-11-04 17:41:29',
                'deleted_at' => null
            ],
            [
                'id' => 9,
                'name' => 'Agis Sukmayadi',
                'email' => 'kotasabang@gmail.com',
                'phone' => '085156134923',
                'email_verified_at' => null,
                'password' => '$2y$12$5.VrtxYYZRvsOzCJ.Mhwl.eCm.bAeW4HWqrsLAAi1BjNfrC6xaIP2',
                'role' => 'Goverment',
                'region' => 'KOTA SABANG',
                'is_verified' => 1,
                'remember_token' => null,
                'created_at' => '2024-11-04 22:03:19',
                'updated_at' => '2024-11-04 22:22:18',
                'deleted_at' => null
            ],
            [
                'id' => 10,
                'name' => 'Pemerintah Daerah Kabupaten Sukabumi',
                'email' => 'kabsukabumi@gmail.com',
                'phone' => '1276276276',
                'email_verified_at' => null,
                'password' => '$2y$12$PoPxDqHf3wEbEpZo6Ci0FunGGkvlgyKRtq5QwMSjW8FSSnwH4hReG',
                'role' => 'Goverment',
                'region' => 'KAB. SUKABUMI',
                'is_verified' => 1,
                'remember_token' => null,
                'created_at' => '2024-11-05 14:14:43',
                'updated_at' => '2024-11-05 14:14:43',
                'deleted_at' => null
            ],
            [
                'id' => 11,
                'name' => 'Pemerintah Daerah Kabupaten Bandung',
                'email' => 'kabbandung@gmail.com',
                'phone' => '12343666',
                'email_verified_at' => null,
                'password' => '$2y$12$GjuKsI5xyeL/aQljf54Smu1JpsfQG5DmyGwM.5rxxawF131ce.C0W',
                'role' => 'Goverment',
                'region' => 'KAB. BANDUNG',
                'is_verified' => 1,
                'remember_token' => null,
                'created_at' => '2024-11-05 14:15:31',
                'updated_at' => '2024-11-05 14:15:31',
                'deleted_at' => null
            ]
        ]);
    }
}
