<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text("description")->nullable();
            $table->string("location");
            $table->string("image")->nullable();
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }

    public function updateStatus($id)
    {
        $destination = Destination::findOrFail($id);

        // toggle status
        $destination->status = $destination->status === 'aktif' ? 'nonaktif' : 'aktif';
        $destination->save();

        return redirect()->back()->with('success', 'Status berhasil diubah!');
    }

};
