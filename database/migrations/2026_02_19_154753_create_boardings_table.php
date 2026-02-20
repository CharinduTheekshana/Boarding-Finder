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
        Schema::create('boardings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('listed_for', ['boys', 'girls', 'both', 'couple', 'family']);
            $table->enum('boarding_type', [
                'annex',
                'apartment',
                'bungalow',
                'business_space',
                'co_working_space',
                'double_room',
                'full_house',
                'guest_house',
                'home_stay',
                'hostel',
                'house',
                'shared_room',
                'single_room',
            ]);
            $table->decimal('price', 10, 2);
            $table->enum('payment_duration', ['monthly', 'quarterly', 'yearly']);
            $table->string('owner_name');
            $table->string('phone_number');
            $table->string('owner_email');
            $table->enum('property_status', ['available', 'not_available'])->default('available');
            $table->enum('furnishing_status', ['furnished', 'not_furnished'])->default('not_furnished');
            $table->string('address');
            $table->string('city');
            $table->string('district')->nullable();
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('beds')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->boolean('kitchen')->default(false);
            $table->boolean('wifi')->default(false);
            $table->boolean('parking')->default(false);
            $table->enum('approved_status', ['pending', 'approved', 'rejected'])->default('pending')->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boardings');
    }
};
