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
        $events = Event::all();
        foreach ($events as $event) {
            Attendee::create([
                'name' => 'Attendee ' . $event->title,
                'email' => 'attendee@example.com',
                'event_id' => $event->id,
            ]);
        }
    }

}
