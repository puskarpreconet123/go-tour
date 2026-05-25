<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\SupportRequest;
use App\Models\Destination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Fetch all existing users to attach bookings and requests to
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        // Dummy destination
        $destination = Destination::firstOrCreate(
            ['name' => 'Dummy Destination'],
            [
                'location' => 'Paris, France',
                'price' => 1000,
                'original_price' => 1200,
                'image_url' => 'https://via.placeholder.com/150',
                'type' => 'place',
                'category' => 'international',
            ]
        );

        // Dummy data for bookings and requests
        foreach ($users as $index => $user) {
            SupportRequest::create([
                'user_id' => $user->id,
                'type' => $index % 2 == 0 ? 'visa' : 'passport',
                'status' => 'pending',
                'notes' => 'Looking for help with ' . ($index % 2 == 0 ? 'visa' : 'passport') . ' application.',
            ]);

            Booking::create([
                'user_id' => $user->id,
                'destination_id' => $destination->id,
                'type' => 'hotel',
                'status' => 'upcoming',
                'total_amount' => 1000,
                'booking_details' => ['passengers' => 1],
            ]);
        }
    }
}
