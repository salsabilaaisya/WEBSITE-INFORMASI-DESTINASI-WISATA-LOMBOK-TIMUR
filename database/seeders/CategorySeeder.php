<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Pantai',
                'description' => 'Wisata pantai Lombok Timur'
            ],
            [
                'name' => 'Air Terjun',
                'description' => 'Wisata air terjun Lombok Timur'
            ],
            [
                'name' => 'Bukit',
                'description' => 'Wisata bukit Lombok Timur'
            ],
            [
                'name' => 'Desa Wisata',
                'description' => 'Wisata desa Lombok Timur'
            ],
            [
                'name' => 'Budaya',
                'description' => 'Wisata budaya Lombok Timur'
            ]
        ]);
    }
}