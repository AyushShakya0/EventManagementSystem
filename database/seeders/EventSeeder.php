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
     */public function run()
    {
        $events = [
            [
                'title' => 'Jazz Night',
                'description' => 'An evening of smooth jazz music featuring local artists.',
                'date' => '2024-11-15',
                'time' => '19:00',
                'location' => 'Downtown Jazz Club',
                'category_id' => 1, // Assuming 'Music' has ID 1
            ],
            [
                'title' => 'Football Match',
                'description' => 'Join us for an exciting football match between local teams.',
                'date' => '2024-11-20',
                'time' => '15:00',
                'location' => 'Convention Center',
                'category_id' => 2, // Assuming 'Sports' has ID 2
            ],
            [
                'title' => 'Painting Workshop',
                'description' => 'A hands-on workshop to explore your creativity with paints.',
                'date' => '2024-11-25',
                'time' => '10:00',
                'location' => 'Convention Center',
                'category_id' => 3, // Assuming 'Arts & Crafts' has ID 3
            ],
            [
                'title' => 'Python Programming 101',
                'description' => 'Learn the basics of Python programming in this beginner-friendly workshop.',
                'date' => '2024-12-01',
                'time' => '09:00',
                'location' => 'Convention Center',
                'category_id' => 4, // Assuming 'Education' has ID 4
            ],
            [
                'title' => 'Tech Expo 2024',
                'description' => 'Explore the latest in technology and innovation at our tech expo.',
                'date' => '2024-12-10',
                'time' => '09:00',
                'location' => 'Convention Center',
                'category_id' => 5, // Assuming 'Technology' has ID 5
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }

}
