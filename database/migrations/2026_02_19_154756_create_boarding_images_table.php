<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('boarding_images')) {
            Schema::create('boarding_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('boarding_id');
                $table->string('image_path');
                $table->unsignedTinyInteger('sort_order')->default(1);
                $table->timestamps();
            });
        }

        try {
            DB::statement('ALTER TABLE boarding_images ADD CONSTRAINT boarding_images_boarding_id_foreign FOREIGN KEY (boarding_id) REFERENCES boardings(id) ON DELETE CASCADE');
        } catch (\Throwable $throwable) {
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_images');
    }
};
