<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {

            $table->id();

            // Hero
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();

            // Vision & Mission
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();

            // Banner Image
            $table->string('image')->nullable();

            // Contact
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Social Media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};