<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Music'],
            ['name' => 'Sports'],
            ['name' => 'Arts & Crafts'],
            ['name' => 'Education'],
            ['name' => 'Technology'],
            ['name' => 'Food & Drink'],
            ['name' => 'Health & Wellness'],
            ['name' => 'Business'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }

}
