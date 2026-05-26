<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->text('short_desc')->nullable();
            $table->longText('long_desc')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('meta_data')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['short_desc', 'long_desc', 'gallery_images', 'meta_data']);
        });
    }
};
