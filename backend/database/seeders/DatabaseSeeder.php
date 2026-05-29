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

        // Seed the 5 static packages from the frontend
        $packages = [
            [
                'name' => '7 Nights Bali Honeymoon Package',
                'location' => 'Bali',
                'price' => 68999,
                'original_price' => null,
                'image_url' => 'assets/images/bali.webp',
                'type' => 'place',
                'category' => 'honeymoon',
                'short_desc' => 'Romantic villas, candlelight dinners, private tours, and unforgettable island experiences for couples.',
                'long_desc' => '<h3>OVERVIEW :</h3>
<p>Enjoy a romantic getaway to the tropical paradise of Bali. This package offers couple-friendly stays in romantic villas, private candlelight dinners, and curated tours to Bali\'s most stunning beaches and temples.</p>
<p>Create unforgettable memories with your partner as you watch the sunset at Uluwatu, explore the lush rice terraces of Ubud, and relax on Kuta\'s pristine sands.</p>
<article class="package-include bg-light-grey" style="padding: 20px; background: #f8f9fa; border-radius: 10px; margin: 20px 0;">
<h3>INCLUDE & EXCLUDE :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Specialized bilingual guide</li>
<li style="margin-bottom: 8px;"><i class="fas fa-times" style="color: #dc3545; margin-right: 10px;"></i>Guide Service Fee</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Private Transport</li>
<li style="margin-bottom: 8px;"><i class="fas fa-times" style="color: #dc3545; margin-right: 10px;"></i>Room Service Fees</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Entrance Fees to attractions</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Breakfast And Lunch Box</li>
<li style="margin-bottom: 8px;"><i class="fas fa-times" style="color: #dc3545; margin-right: 10px;"></i>Any Private Expenses</li>
</ul>
</article>
<h3>ITINERARY :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 1: Arrival & Villa Check-in</strong><br>Welcome to Bali! Meet our representative at Denpasar Airport and transfer to your romantic villa in Ubud. Spend the evening at leisure.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 2: Ubud Cultural Tour & Rice Terraces</strong><br>Visit the sacred Monkey Forest, traditional Ubud market, and Tegalalang Rice Terraces. Enjoy a local lunch overlooking the valley.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 3: Romantic Candlelight Dinner</strong><br>Relax in the morning. In the evening, enjoy a private candlelight dinner with a custom 3-course menu in the privacy of your resort.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 4: Departure</strong><br>After breakfast, transfer back to the airport for your flight home.</div></li>
</ul>',
                'meta_data' => [
                    'duration' => '7D/6N',
                    'pax' => 'Couple Friendly',
                ]
            ],
            [
                'name' => 'Dubai Luxury Family Tour',
                'location' => 'Dubai',
                'price' => 54999,
                'original_price' => null,
                'image_url' => 'assets/images/dubai.avif',
                'type' => 'place',
                'category' => 'international',
                'short_desc' => 'Explore Dubai Mall, desert safari, Burj Khalifa, cruises, and premium family entertainment.',
                'long_desc' => '<h3>OVERVIEW :</h3>
<p>Take your family on a mesmerizing journey to the city of gold. Experience high-tech theme parks, luxury shopping malls, and historical cruises alongside thrilling desert safaris.</p>
<p>This packages covers entry tickets to the Burj Khalifa 124th-floor observation deck and a premium dhow cruise dinner.</p>
<article class="package-include bg-light-grey" style="padding: 20px; background: #f8f9fa; border-radius: 10px; margin: 20px 0;">
<h3>INCLUDE & EXCLUDE :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Burj Khalifa Entry Ticket</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Desert Safari with BBQ Dinner</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Daily Buffet Breakfast</li>
<li style="margin-bottom: 8px;"><i class="fas fa-times" style="color: #dc3545; margin-right: 10px;"></i>Visa Fees & Tourism Dirham</li>
<li style="margin-bottom: 8px;"><i class="fas fa-times" style="color: #dc3545; margin-right: 10px;"></i>Any private shopping</li>
</ul>
</article>
<h3>ITINERARY :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 1: Welcome to Dubai & Dhow Cruise</strong><br>Arrive in Dubai, transfer to your 4-star hotel. In the evening, enjoy a traditional Marina Dhow Cruise with a buffet dinner.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 2: Dubai City Tour & Burj Khalifa</strong><br>Explore Jumeirah Beach, Atlantis Hotel (photo stop), and take the high-speed elevator to the 124th floor of Burj Khalifa.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 3: Desert Safari & BBQ Show</strong><br>Hop on a 4x4 Land Cruiser for dune bashing, sandboarding, and camel rides, followed by Tanoura dancing and BBQ dinner.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 4: Departure</strong><br>Transfer to Dubai Airport for departure flight.</div></li>
</ul>',
                'meta_data' => [
                    'duration' => '5D/4N',
                    'pax' => 'Family Package',
                ]
            ],
            [
                'name' => 'Kashmir Scenic Escape',
                'location' => 'Kashmir',
                'price' => 32999,
                'original_price' => null,
                'image_url' => 'assets/images/DalLake.webp',
                'type' => 'place',
                'category' => 'national',
                'short_desc' => 'Enjoy Srinagar, Gulmarg, Pahalgam, local cuisine, snowfall, and breathtaking natural beauty.',
                'long_desc' => '<h3>OVERVIEW :</h3>
<p>Escape to the "Paradise on Earth". Admire the snow-capped mountain ranges of Gulmarg, ride a shikara on Dal Lake, and walk through the blooming valleys of Pahalgam.</p>
<article class="package-include bg-light-grey" style="padding: 20px; background: #f8f9fa; border-radius: 10px; margin: 20px 0;">
<h3>INCLUDE & EXCLUDE :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>1 Night Houseboat Stay</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Shikara Ride on Dal Lake</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>All transfers by private cab</li>
<li style="margin-bottom: 8px;"><i class="fas fa-times" style="color: #dc3545; margin-right: 10px;"></i>Gondola cable car ride tickets</li>
</ul>
</article>
<h3>ITINERARY :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 1: Srinagar Arrival & Houseboat Stay</strong><br>Check in to a premium houseboat on Dal Lake. Enjoy a scenic Shikara ride at sunset.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 2: Srinagar to Gulmarg</strong><br>Drive to Gulmarg, the meadow of flowers. Enjoy the snow activities and optional Gondola ride.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 3: Gulmarg to Pahalgam</strong><br>Transfer to Pahalgam. Visit Saffron fields, Avantipura ruins, and rest in the tranquil pine woods.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 4: Departure</strong><br>Drive back to Srinagar Airport for your onward journey.</div></li>
</ul>',
                'meta_data' => [
                    'duration' => '6D/5N',
                    'pax' => 'Group Tour',
                ]
            ],
            [
                'name' => 'Maldives Luxury Escape',
                'location' => 'Maldives',
                'price' => 94999,
                'original_price' => 125000,
                'image_url' => 'assets/images/img8.jpg',
                'type' => 'deal',
                'category' => 'honeymoon',
                'short_desc' => 'Experience private villas, crystal-clear waters, and luxury island stays at special prices.',
                'long_desc' => '<h3>OVERVIEW :</h3>
<p>Indulge in a premium overwater villa stay in the Maldives. Enjoy absolute privacy, gorgeous coral reefs, snorkeling, and pristine ocean views directly from your balcony.</p>
<article class="package-include bg-light-grey" style="padding: 20px; background: #f8f9fa; border-radius: 10px; margin: 20px 0;">
<h3>INCLUDE & EXCLUDE :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>3 Nights Overwater Villa stay</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Speedboat Transfers</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>All-inclusive meals</li>
<li style="margin-bottom: 8px;"><i class="fas fa-times" style="color: #dc3545; margin-right: 10px;"></i>International flights</li>
</ul>
</article>
<h3>ITINERARY :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 1: Speedboat Transfer & Villa Check-In</strong><br>Arrive at Male Airport, board the speedboat transfer to your resort island and check in to your luxury villa.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 2: Snorkeling & Water Sports</strong><br>Explore the colorful marine ecosystem with guided snorkeling. Try windsurfing or paddleboarding.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 3: Spa & Sunset Cruise</strong><br>Rejuvenate at the resort spa in the afternoon. In the evening, enjoy a sunset cruise with dolphin watching.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 4: Departure</strong><br>Board the speedboat back to Male Airport for departure.</div></li>
</ul>',
                'meta_data' => [
                    'duration' => '7D/6N',
                    'pax' => 'pax: 10',
                ]
            ],
            [
                'name' => 'Paris Romantic Getaway',
                'location' => 'France',
                'price' => 89999,
                'original_price' => 110000,
                'image_url' => 'assets/images/img9.jpg',
                'type' => 'deal',
                'category' => 'international',
                'short_desc' => 'Discover the Eiffel Tower, Seine cruises, luxury shopping, and romantic European charm.',
                'long_desc' => '<h3>OVERVIEW :</h3>
<p>Immerse yourself in Paris, the City of Light. Visit the Eiffel Tower observation deck, cruise along the River Seine, and wander through historic Montmartre streets.</p>
<article class="package-include bg-light-grey" style="padding: 20px; background: #f8f9fa; border-radius: 10px; margin: 20px 0;">
<h3>INCLUDE & EXCLUDE :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Eiffel Tower 2nd Floor access</li>
<li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>Seine River Cruise ticket</li>
<li style="margin-bottom: 8px;"><i class="fas fa-times" style="color: #dc3545; margin-right: 10px;"></i>Lunch and dinners</li>
</ul>
</article>
<h3>ITINERARY :</h3>
<ul style="list-style: none; padding-left: 0;">
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 1: Welcome to Paris</strong><br>Check in to your boutique Parisian hotel. Spend the afternoon exploring the Champs-Élysées.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 2: Eiffel Tower & River Cruise</strong><br>Ascend the Eiffel Tower for panoramic city views. Follow it with a leisurely cruise along the Seine.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 3: Louvre Museum & Art Walk</strong><br>Skip the line to see the Mona Lisa at the Louvre, then spend the evening in the artsy Montmartre district.</div></li>
<li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;"><i class="fas fa-dot-circle" style="color: #ff5722; margin-top: 5px;"></i><div><strong>DAY 4: Departure</strong><br>Transfer to Charles de Gaulle Airport for your flight back home.</div></li>
</ul>',
                'meta_data' => [
                    'duration' => '5D/4N',
                    'pax' => 'pax: 10',
                ]
            ],
        ];

        foreach ($packages as $pkg) {
            Destination::firstOrCreate(
                ['name' => $pkg['name']],
                $pkg
            );
        }

        // Fetch all existing users to attach bookings and requests to
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        // Dummy destination for default booking
        $destination = Destination::first();

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
