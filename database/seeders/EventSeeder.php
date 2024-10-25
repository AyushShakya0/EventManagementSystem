<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            Event::create([
                'title' => 'Event for ' . $category->name,
                'description' => 'Description for ' . $category->name,
                'date' => now()->addDays(rand(1, 30)),
                'location' => 'Location for ' . $category->name,
                'category_id' => $category->id,
            ]);
        }
    }

}
