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
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('type', ['selling', 'renting']);
            $table->enum('property_type', ['house', 'apartment', 'urban land', 'rural land']);
            $table->string('city')->default('Pelotas');
            $table->string('neighborhood');
            $table->text('description');
            // $table->json('images');
            $table->float('area');
            $table->integer('bedrooms')->default(0);
            $table->integer('bathrooms')->default(0);
            $table->integer('car_spots')->default(0);
            $table->decimal('price', 20, 2)->nullable(); // Assuming price with 2 decimal points
            $table->decimal('rent', 20, 2)->nullable();  // Assuming rent with 2 decimal points
            $table->decimal('condo_price', 10, 2)->nullable();  // Assuming condo price with 2 decimal points
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
