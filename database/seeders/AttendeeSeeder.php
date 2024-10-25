<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $attendees = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'phone' => '123-456-7890',
                'event_id' => 1, // Attending 'Jazz Night'
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'phone' => '987-654-3210',
                'event_id' => 2, // Attending 'Football Match'
            ],
            [
                'name' => 'Charlie Brown',
                'email' => 'charlie@example.com',
                'phone' => '555-555-5555',
                'event_id' => 3, // Attending 'Painting Workshop'
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'phone' => '444-444-4444',
                'event_id' => 4, // Attending 'Python Programming 101'
            ],
            [
                'name' => 'Emma Davis',
                'email' => 'emma@example.com',
                'phone' => '222-222-2222',
                'event_id' => 5, // Attending 'Tech Expo 2024'
            ],
        ];

        foreach ($attendees as $attendee) {
            Attendee::create($attendee);
        }
    }

}
