<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // Seed Products
        $products = [
            [
                'name' => 'Tahu Organik Segar',
                'description' => 'Tahu organik berkualitas premium yang dibuat dari kacang kedelai pilihan.',
                'price' => 15000,
                'category' => 'Protein',
                'stock' => 50,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Tempe Goreng',
                'description' => 'Tempe goreng renyah dengan cita rasa tradisional yang nikmat.',
                'price' => 12000,
                'category' => 'Protein',
                'stock' => 60,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sayuran Segar Organik',
                'description' => 'Paket sayuran segar organik pilihan untuk keluarga Anda.',
                'price' => 45000,
                'category' => 'Sayuran',
                'stock' => 40,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Nasi Kuning Vegetarian',
                'description' => 'Nasi kuning lezat dengan bumbu tradisional dan bahan-bahan pilihan.',
                'price' => 25000,
                'category' => 'Makanan Jadi',
                'stock' => 30,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Jus Buah Segar',
                'description' => 'Jus buah segar tanpa pengawet, dibuat fresh setiap hari.',
                'price' => 18000,
                'category' => 'Minuman',
                'stock' => 70,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Salad Buah Premium',
                'description' => 'Salad buah premium dengan dressing madu yang sehat dan lezat.',
                'price' => 35000,
                'category' => 'Sayuran',
                'stock' => 25,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($products as $product) {
            $this->db->table('products')->insert($product);
        }

        // Seed Admin User
        $adminUser = [
            'username' => 'admin',
            'email' => 'admin@vegetarian.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name' => 'Administrator',
            'role' => 'admin',
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('admin_users')->insert($adminUser);

        // Seed Settings
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'Vegetarian Paradise',
                'description' => 'Nama perusahaan',
            ],
            [
                'key' => 'company_tagline',
                'value' => 'Hidup Sehat Dimulai dari Pilihan Makanan yang Tepat',
                'description' => 'Tagline perusahaan',
            ],
            [
                'key' => 'company_description',
                'value' => 'Kami adalah perusahaan yang berkomitmen menyediakan produk vegetarian berkualitas tinggi untuk mendukung gaya hidup sehat Anda.',
                'description' => 'Deskripsi perusahaan',
            ],
            [
                'key' => 'company_phone',
                'value' => '+62 812 3456 7890',
                'description' => 'Nomor telepon perusahaan',
            ],
            [
                'key' => 'company_email',
                'value' => 'info@vegetarian.com',
                'description' => 'Email perusahaan',
            ],
            [
                'key' => 'company_address',
                'value' => 'Jl. Sehat No. 123, Jakarta 12345',
                'description' => 'Alamat perusahaan',
            ],
        ];

        foreach ($settings as $setting) {
            $setting['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('settings')->insert($setting);
        }
    }
}
