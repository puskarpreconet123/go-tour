<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type'); // hotel, flight, train, event
            $table->enum('status', ['upcoming', 'past', 'cancelled'])->default('upcoming');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->json('booking_details')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
