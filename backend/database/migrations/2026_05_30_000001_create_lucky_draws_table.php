<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('lucky_draws', function (Blueprint $table) {
        $table->id();
        // Link to the packages/destinations table
        $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
        $table->decimal('ticket_price', 8, 2)->default(0.00);
        $table->dateTime('start_date');
        $table->dateTime('end_date');
        // Status can be: 'active', 'finished'
        $table->string('status')->default('active');
        // The winner (foreign key to users table, nullable until drawn)
        $table->foreignId('winner_id')->nullable()->constrained('users')->onDelete('set null');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('lucky_draws');
    }
};